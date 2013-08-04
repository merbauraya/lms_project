<?php

class CirculationController extends Controller
{
	public $layout='//layouts/column2';
	
	public function filters()
	{
		return array(
			array('auth.filters.AuthFilter'),
          
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('checkout','checkin','renewal'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionCheckin()
	{
		$model = new CirculationTrans();
		if (isset($_POST['accession']))
		{
			$accession = $_POST['accession'];//['accession_number'];
			$result = CirculationTrans::model()->validateCheckoutItem($accession);
			if (!$result['ret'])
			{
				echo CJSON::encode(array(
				'status'=>'fail', 
				'message'=>$result['message'],
				));	
			}else //item is valid for checkin
			{
				
				if (self::itemCheckin($accession))
					echo CJSON::encode(array(
					'status'=>'success', 
					'message'=>'Item successfully checked in',
					'cat_title'=>$result['title']
					));	
				else //error while checking in
				{
					echo CJSON::encode(array(
					'status'=>'fail', 
					'message'=>'Error checking in',
					'cat_title'=>$result['title']
					));	
				}
			}
		
		}else
		{
			//Yii::app()->user->setFlash('error','This is error message');
			$this->render('checkin',array('model'=>$model,'action'=>'Checkin','title'=>'Checkin'));
		}
	}
	/*
	*	Helper function to peform actual item check in
	*
	*/
	private function itemCheckin($accession)
	{
		$tstamp = LmUtil::dBCurrentDateTime();
		
		//update catalog_item status
		$sql = "update catalog_item
					set date_last_seen = :co_date,
					date_last_checked_in = :co_date,
					check_out_date = null
					where accession_number = :accession";
		
		$sql2 = "update cir_transaction
					set checkin_date = :co_date
					where accession_number = :accession";
		
		//move transaction to history
		$sql3 = "insert into cir_transaction_history
				(library_id, patron_username,accession_number,checkout_date, 
				due_date,checkin_date,last_renewed_date,renew_count)
				select library_id,patron_username,accession_number,checkout_date, 
					due_date,checkin_date,last_renewed_date, renew_count
					from cir_transaction
					where accession_number = :accession ";
		
		$sql4 = "delete from cir_transaction
					where accession_number = :accession ";
		
		
		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->bindParam(':co_date',$tstamp,PDO::PARAM_STR);
		$cmd->bindParam(':accession',$accession,PDO::PARAM_STR);
		
		$cmd2 = Yii::app()->db->createCommand($sql2);
		$cmd2->bindParam(':co_date',$tstamp,PDO::PARAM_STR);
		$cmd2->bindParam(':accession',$accession,PDO::PARAM_STR);
		
		$cmd3 = Yii::app()->db->createCommand($sql3);
		$cmd3->bindParam(':accession',$accession,PDO::PARAM_STR);
		
		$cmd4 = Yii::app()->db->createCommand($sql4);
		$cmd4->bindParam(':accession',$accession,PDO::PARAM_STR);
		
		
		$trans = Yii::app()->db->beginTransaction();
		try
		{
			$cmd->execute();
			$cmd2->execute();
			$cmd3->execute();
			$cmd4->execute();
			$trans->commit();
			return true;
		}catch (Exception $ex)
		{
			$trans->rollback();
			LmUtil::le($this,$ex->getMessage());
			return false;
		}
		
					
	
	}
	/**
	*
	*	Checkout an item/accession
	*
	*/
	public function actionCheckOut()
	{
		$this->layout='//layouts/column1';
        $model = new CirculationTrans;
        $this->performAjaxValidation($model);
        
                
		if (isset($_POST['CirculationTrans']))
		{
			$model->attributes = $_POST['CirculationTrans'];
			$sql = "update catalog_item
					set date_last_checked_out = :co_date,
					check_out_date = :co_date,
                    date_last_seen = :co_date,
					reserved = false,
					checkout_count = checkout_count+1
					where accession_number = :accession";
			
			$cmd = Yii::app()->db->createCommand($sql);
			$tstamp = LmUtil::dBCurrentDateTime();
			$accession = $model->accession_number;
			$cmd->bindParam(':co_date',$tstamp,PDO::PARAM_STR);
			$cmd->bindParam(':accession',$accession,PDO::PARAM_STR);
			
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				$model->checkout_date = LmUtil::dBCurrentDateTime();
				$model->save();
				$cmd->execute();
				$trans->commit();
			/*	echo CJSON::encode(array(
					'status'=>'success', 
					'message'=>'Item checkout successfully'
				)); */
				Yii::app()->user->setFlash('success','Item checkout successfully');
                $model->unsetAttributes();
			}catch (Exception $ex)
			{
				$trans->rollback();
				LmUtil::le($this,$ex->getMessage());
				Yii::app()->user->setFlash('error','Error checking out item');
			}
		}
        $this->render('checkout',array('model'=>$model));
	}
     /**
     * Get patron status and holding information
     * 
     * 
     */ 
    public function actionGetStatusAndHolding()
    {
        
        //echo $_REQEUST['username'];
        
        if (isset($_REQUEST['username']) && isset($_REQUEST['library']))
        {
        
            $username = $_REQUEST['username'];
            $library = $_REQUEST['library'];
            $returntype = '';
            if (isset($_REQUEST['ret']))
                $returnType = $_REQUEST['ret'];
            $sql = 'select 
                    a.id,a.name,a.username,d.name as status_name,d.allow_checkout,
                    b.accession_number,b.checkout_date,b.due_date
                    from patron a
                    left outer join cir_transaction b on a.username = b.patron_username 
                    left outer join catalog_item c on b.accession_number  = c.accession_number
                    ,patron_status d
                    where username = :username
                    and a.library_id = :library
                    and d.id = a.status_id ';

            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(':username',$username,PDO::PARAM_STR);
            $cmd->bindValue(':library',$library,PDO::PARAM_INT);
            
            $results = $cmd->queryAll(); //return all rows
            $result = $cmd->execute() ; //exec update insert delete stmt
            
            $buffer = array();
            if (count($results)>0)
            {
                $msg='';
                if (!$results[0]['allow_checkout'] )
                    $msg = '<strong>Checkout not allowed </strong><br>' . $results[0]['status_name'];
                
                $buffer['user'] = array('name'=> $results[0]['name'],
                                      'allowcheckout'=>$results[0]['allow_checkout'],
                                      'statusname'=>$results[0]['status_name'],
                                      'msg'=>$msg,
                                      'id'=>'username',
                
                );
            }else
            {
                $buffer['user']= array('allowcheckout'=>false,
                                        'msg'=>'Patron does not exist');
            }
            //$buffer['user'] = null;
            foreach ($results as $result)
            {
                $buffer['holding'][] = array('accession'=>'accession_number',
                                            'checkoutdate'=>'checkout_date',
                                            'duedate'=>'due_date'); 
                
            }
            
            if ($returnType == 'json')
                echo CJSON::encode($buffer);
            else
                echo $buffer;
            //echo CJSON::encode(array(
			//'status'=>'failure', 
			//'div'=>$this->renderPartial('_receiveDialog',array('model'=>$model,'rID'=>$rID),true)));
            //exit;   
        }
    }
	public function actionRenewal()
	{
		$model = new CirculationTrans();
		$this->render('check_in_renew',array('model'=>$model));
	}
	private function getDueDate($accession,$patron)
	{
		$patron = Patron::model()->findByAttribute('username',$patron)->with('PatronCategory');	
		
	}
    /**
     * Render list of holding currently checked out by user
     * This is a get method function
     * Expect param username
     * 
     */
    public function actionViewUserHolding()
    {
        if (!isset($_GET['username']))
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        
        $username = $_GET['username'];
        $sql =  'select count(*) as total
                 from cir_transaction a,catalog_item b,"catalog" c,lookup_table d
                 where patron_username=:username
                 and a.accession_number = b.accession_number
                 and b.control_number = c.control_number
                 and d.category=\'ITEM_SMD\'
                 and b.smd_id = d.id';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':username',$username,PDO::PARAM_STR);
        $count = $cmd->queryScalar();
        
        $sql =  'select a.id,a.accession_number,a.checkout_date,a.due_date,c.title_245a as title,d.name as smd_name
                 from cir_transaction a,catalog_item b,"catalog" c,lookup_table d
                 where patron_username=:username
                 and a.accession_number = b.accession_number
                 and b.control_number = c.control_number
                 and d.category=\'ITEM_SMD\'
                 and b.smd_id = d.id';
        
        //$cmd = Yii::app()->db->createCommand($sql);
        //$cmd->bindValue(':username',$username,PDO::PARAM_STR);
        $itemDP=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'params'=>array(':username'=>$username),
            'sort'=>array(
                'attributes'=>array(
                     'due_date',
                ),
            ),
            'pagination'=>array(
            'pageSize'=>10,
            ),
        ));
         if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_userholding',array('itemDP'=>$itemDP));
        
    }
    
    /**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='checkout-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
