<?php

class CirculationController extends Controller
{
	public $layout='//layouts/column2';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
		$model = new CirculationTrans;
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
				echo CJSON::encode(array(
					'status'=>'success', 
					'message'=>'Item checkout successfully'
				));
				Yii::app()->user->setFlash('success','Item checkout successfully');
			}catch (Exception $ex)
			{
				$trans->rollback();
				LmUtil::le($this,$ex->getMessage());
				Yii::app()->user->setFlash('error','Error checking out item');
			}
		}
		
		$this->render('checkout',array('model'=>$model));
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
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
