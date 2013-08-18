<?php

class AcquisitionRequestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','loadsuggestionitem',
				'promoteSuggestion','rejectSuggestion','UpdateItem','approvallist',
				'loadRequestItem','ApproveItem','rejectItem','deleteItem','createItem'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$operation = 'addRequest';
		$model = new AcquisitionRequest;
		
		$session = Yii::app()->session;
		//$session['isQuote'] = Invoice::DOC_QUOTATION;
		if (isset($_POST['AcquisitionRequest']))
		{
			$model->attributes=$_POST['AcquisitionRequest'];
            $model->library_id = LmUtil::UserLibraryId();
			//$model->suggested_by =  Yii::app()->user->getId();
            if ($_POST['selfrequest'] == 1)
                $model->requested_by = LmUtil::UserId();
			$items =  new AcquisitionRequestItem;
			if($model->save())
				$this->redirect(array('update',
									  'id'=>$model->id				  
									  )
							    ); 
		} else {
			
			$this->render('create',array('model'=>$model));
		}
	
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id)->with('patron');
		
		$items = new AcquisitionSuggestionItem;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AcquisitionRequest']))
		{
			$model->attributes=$_POST['AcquisitionRequest'];
			$model->status_id = AcquisitionRequest::REQUEST_NEW;
			//$model->suggested_by = Yii::app()->user->getId(); 
			if (!$model->save())
				Yii::app()->user->setFlash('error', '<strong>Error!</strong> Error saving record');
				
		}
		if (isset($_POST['AcquisitionRequestItem']))
			{
				$items = $_POST['AcquisitionRequestItem'];
				foreach($items as $i=>$item)
					if (isset($_POST['AcquisitionRequestItem'][$i]))
					{
						$acqItem = new AcquisitionRequestItem;
						$acqItem->attributes = $_POST['AcquisitionRequestItem'][$i];
						$acqItem->save(false);	
					}
					$this->redirect(array('update','id'=>$model->id)); 
				
			}
		
		//get list of active suggestion for this library
		//todo filter active suggestion by dept/faculy for current user
		$suggModel = AcquisitionSuggestion::model()->getActiveSuggestion($model->library_id,$model->department_id);
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'acq_request_id= :id';
		$criteria->params = array(':id'=>$id);
		$itemDP=new CActiveDataProvider(
			'AcquisitionRequestItem',
			array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => '20',
				)
			)
		);
		
		$this->render('update',array(
			'model'=>$model,'items'=>$items,'suggModel'=>$suggModel,'itemDP'=>$itemDP
		));
	}

	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AcquisitionRequest');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AcquisitionRequest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AcquisitionRequest']))
			$model->attributes=$_GET['AcquisitionRequest'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AcquisitionRequest::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Render suggestion Item based on the given suggestion id
	 *
	 * @param integer the ID of the suggestion Item to be loaded
	 */
	public function actionLoadSuggestionItem($id)
	{
		
		$criteria = new CDbCriteria(); 
		$criteria->condition = 'acq_suggestion_id= :id and status_id = :status';
		
		$criteria->params = array(':id'=>$id,':status'=>AcquisitionSuggestionItem::ITEM_STATUS_NEW); 
		
		$itemsDP=new CActiveDataProvider( 'AcquisitionSuggestionItem', array( 'criteria' => $criteria, 'pagination' => array( 'pageSize' => '20', ) ) );
		
		//prevent the following script to be re-rendered
		if (Yii::app()->request->isAjaxRequest){
			Yii::app()->clientscript->scriptMap['jquery.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.bootbox.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false; 
            Yii::app()->clientscript->scriptMap['Chart.js'] = false; 
		}
		
		$this->renderPartial('_sugg_item_list',array('itemsDP'=>$itemsDP),false,true);
	
	
	}
	/**
	* Performs promoting suggestion item to request item
	* This is ajax only request
	*
	*/
	public function actionPromoteSuggestion()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
        {
            $user_id = LmUtil::UserId();
			$itemIds = $_POST['ids'];
			$request_id = $_POST['rid'];
			$criteria = new CDbCriteria();
			$criteria->addInCondition('id',$itemIds);
			$attributes = array('status_id'=>AcquisitionSuggestionItem::ITEM_STATUS_PROMOTED,
								'status_update_by'=>Yii::app()->user->getId(),
								'acq_request_id'=> $request_id);
			
			
			$sql = 'update acq_suggestion_item
			        set status_id = :status_id,
					status_update_by = :update_by,
					acq_request_id = :request_id
					where id in (';
			$idPlaceholder = LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds);
			$sql .= $idPlaceholder .')';
			//now bind all the params
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
			$sugg_status = AcquisitionSuggestionItem::ITEM_STATUS_PROMOTED;
			$cmd->bindParam(':status_id',$sugg_status,PDO::PARAM_INT);
			$cmd->bindParam(':update_by',$user_id,PDO::PARAM_INT);
			$cmd->bindParam(':request_id',$request_id,PDO::PARAM_INT);
			
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				//start by updating suggestion item status 
				$cmd->execute();
				$sql = 'insert into acq_request_item (isbn,isbn_13,title,author,edition,number_of_copy, currency_id,price,local_price,note,acq_request_id,
				created_by,status_id,publisher,acq_suggestion_item_id)
				
				select isbn,isbn_13,title,author,edition,number_of_copy,	currency_id,price,local_price,note,:request_id,
				:created_by,:item_status,publisher,id
				from acq_suggestion_item
				where id in ('. $idPlaceholder .')';
				
				$cmd2 = Yii::app()->db->createCommand($sql);
				for ($i = 0; $i < count($itemIds);++$i)
					$cmd2->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
				$request_status = AcquisitionRequestItem::STATUS_NEW;
				$cmd2->bindParam(':request_id',$request_id,PDO::PARAM_INT);
				$cmd2->bindParam(':created_by',$user_id,PDO::PARAM_INT);
				$cmd2->bindParam(':item_status',$request_status,PDO::PARAM_INT);
				$ret = $cmd2->execute();
				
				$transaction->commit();
                echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>$ret .' Item(s) successfully promoted'
				));
			} catch (Exception $ex)
			{
				$transaction->rollback();
				LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
                echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>'Error while promoting item'
				));
			
			}
				
			
        }else
		{
			//we decline non post request
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	
	}
	public function actionRejectSuggestion()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
        {
            $itemIds = $_POST['ids'];
			$sql = 'update acq_request_item
			set status_id= :status_id,
			approved_rejected_by = :updated_by,
			approve_reject_date = :date,
			modified_date = :modified_date
			where id in (' . LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds).')';
			
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
			
			$status = AcquisitionRequestItem::STATUS_REJECTED;
			$userID = LmUtil::UserId();
			$now = LmUtil::dBCurrentDateTime();
			$cmd->bindParam(':status_id',$status,PDO::PARAM_INT);
			$cmd->bindParam(':updated_by',$userID,PDO::PARAM_INT);
			$cmd->bindParam(':modified_date',$now,PDO::PARAM_STR);
			$cmd->bindParam(':date',$now,PDO::PARAM_STR);
			try
			{
				$ret = $cmd->execute();
				echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>$ret .' Item(s) rejected'
				));
				
			}catch (Exception $ex)
			{
				
				echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>'Error while updating request item'
				));	
			}
			
			
            
        }
	
	}
	/**
	*  
	*
	* @param id item id to be updated
	*/
	public function actionUpdateItem($id)
	{
        $modelItem=AcquisitionRequestItem::model()->findByPk($id);
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['AcquisitionRequestItem']))
        {
            $modelItem->attributes=$_POST['AcquisitionRequestItem'];
            if($modelItem->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>"Item successfully updated"
                        ));
                    exit;               
                }
                else
                    $this->redirect(array('view','id'=>$modelItem->id));
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form_item_popup', array('model'=>$modelItem), true)));
            exit;               
        }
        else
            $this->render('create',array('model'=>$model,));
          
          
        }
	/**
	*	Provide list of request that need to be actioned (approved/reject)
	*
	*
	*/
	public function actionApprovalList()
	{
		$user_id = Yii::app()->user->getId();
		
		
		
		$criteria = new CDbCriteria();
		$criteria->condition = 't.status_id = :status_id';
		$criteria->params = array(':status_id'=>AcquisitionRequest::REQUEST_NEW);
		$criteria->with = array('patron','patron.department');
		$requestDP=new CActiveDataProvider( 'AcquisitionRequest', array( 	'criteria' => $criteria, 
		'pagination' => array( 'pageSize' => '20', ) ) 
		);
		/*
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
		{
			$ids = $_POST['ids'];
		
		}else
		{
			$ids = array(0);
		}
		*/
		$ids = array(0);
		$itemModel = new AcquisitionRequestItem("searchNewItemByRequestId($ids)");
		
		//$requestItemDP = AcquisitionRequestItem::model()->searchNewItemByRequestId($ids);
		
		$this->render('approval_list',array('requestDP'=>$requestDP,'parentID'=>$ids,'itemModel'=>$itemModel));
	
	}
	public function actionLoadRequestItem()
	{
		
		//user click load item
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
		{
			
			$parentID =  $_POST['ids'];
			$criteria = new CDbCriteria();
			$criteria->addInCondition('acq_request_id',$parentID);
			$criteria->condition = 'status= :status_id';
			
			$criteria->params = array(':status_id'=>AcquisitionRequestItem::STATUS_NEW);
			
			//store selected parent id in session, it might come handy later
			Yii::app()->session['_suggIds'] = $parentID;
			
		}
		//could be refreshing, sorting
		else
		{
			if (isset(Yii::app()->session['_suggIds']))
				$parentID = Yii::app()->session['_suggIds'];
			else
				$parentID = array(0);
		}		
		
		$itemModel =new AcquisitionRequestItem("searchNewItemByRequestId($parentID)");
		//prevent the following script to be re-rendered	 
		if (Yii::app()->request->isAjaxRequest){
				Yii::app()->clientscript->scriptMap['jquery.js'] = false; 
				Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false; 
				Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false; 
				Yii::app()->clientscript->scriptMap['bootstrap.js'] = false; 
				Yii::app()->clientscript->scriptMap['bootstrap.bootbox.min.js'] = false; 
				Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false; 
		}
		
		$this->renderPartial('_grid_request_item',array('parentID'=>$parentID,'itemModel'=>$itemModel));//,false,false);
		
		
		
		
		
	
	}
	/**
	* Approve selected request Item
	* This should be called via ajax 
	* 
	*/
	public function actionApproveItem()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
        {
            $itemIds = $_POST['ids'];
			$sql = 'update acq_request_item
			        set status_id= :status_id,
					approved_rejected_by = :updated_by,
					approve_reject_date = :date,
					modified_date = :modified_date
					where id in (' . LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds).')';
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
			$status = AcquisitionRequestItem::STATUS_APPROVED;
			$userID = LmUtil::UserId();
			$now = LmUtil::dBCurrentDateTime();
			$cmd->bindParam(':status_id',$status,PDO::PARAM_INT);
			$cmd->bindParam(':updated_by',$userID,PDO::PARAM_INT);
			$cmd->bindParam(':modified_date',$now,PDO::PARAM_STR);
			$cmd->bindParam(':date',$now,PDO::PARAM_STR);
			
			try
			{
				$ret = $cmd->execute();
				echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>$ret .' Item(s) successfully approved'
				));
				
			}catch (Exception $ex)
			{
				echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>'Error while approving item'
				));
			}
			
		
        }
		else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	
	}
	/**
	* Reject selected request Item
	* This should be called via ajax 
	* 
	*/
	public function actionRejectItem()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
        {
            $itemIds = $_POST['ids'];
			$sql = 'update acq_request_item
			set status_id= :status_id,
			approved_rejected_by = :updated_by,
			approve_reject_date = :date,
			modified_date = :modified_date
			where id in (' . LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds).')';
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
			$cmd->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
			$status = AcquisitionRequestItem::STATUS_REJECTED;
			$userID = LmUtil::UserId();
			$now = LmUtil::dBCurrentDateTime();
			$cmd->bindParam(':status_id',$status,PDO::PARAM_INT);
			$cmd->bindParam(':updated_by',$userID,PDO::PARAM_INT);
			$cmd->bindParam(':modified_date',$now,PDO::PARAM_STR);
			$cmd->bindParam(':date',$now,PDO::PARAM_STR);
			try
			{
				$ret = $cmd->execute();
				echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>$ret .' Item(s) rejected'
				));
				
			}catch (Exception $ex)
			{
				
				echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>'Error while updating request item'
				));	
			}
        }
		else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	
	}
    /**
     * Delete Acquisition Request Item
     * 
     * 
     * 
     * 
     */
     
	public function actionDeleteItem()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
		{
			$itemIds = $_POST['ids'];
			//if item is from suggestion, we revert update suggestion status to rejected
			
            $sql = 'update acq_suggestion_item
                   set status_id = :status
                   where id in (
                    select acq_suggestion_item_id from acq_request_item
                    where id in (' ;
            
            $idPlaceholder = LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds);
			$sql .= $idPlaceholder .'))';
			//now bind all the params
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindValue(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
            
            $cmd->bindValue(':status',AcquisitionSuggestion::SUGGESTION_REJECTED);
            
            
            //else we just simply delete the item
			$sql = 'delete from acq_request_item where id in (';
            $idPlaceholder = LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds);
			$sql .= $idPlaceholder .')';
			//now bind all the params
			$cmd2 = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd2->bindValue(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
            
            $transaction =  Yii::app()->db->beginTransaction();
			try 
            { 
                $cmd->execute();
                $cmd2->execute();
                $transaction->commit();
                echo CJSON::encode(array(
                    'status'=>'success',
                    'message'=>'Request items deleted')
                );
			
            }catch (CException $ex)
			{
				$transaction->rollBack();
                LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.'.'.$this->action->id);
				echo CJSON::encode(array(
                    'status'=>'error',
                    'message'=>'Error while deleting item')
                );
			}
            
			
				
		}else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');	
			
		}
		
	}
	/**
	 * Create new suggestion item
		*
	 * @param id integer Request ID
	 */
	
	public function actionCreateItem($id='')
	{
        $modelItem= new AcquisitionRequestItem();
        $modelItem->acq_suggestion_id=$id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
		
        if(isset($_POST['AcquisitionSuggestionItem']))
        {
            $modelItem->attributes=$_POST['AcquisitionSuggestionItem'];
            $modelItem->acq_suggestion_id=$id;
            unset($modelItem->id); //let db generate our key
			$modelItem->status_id = AcquisitionSuggestionItem::ITEM_STATUS_NEW;
            if($modelItem->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
					'status'=>'success',
					'div'=>"Item successfully created"
					));
                    exit;
                }
                else
				$this->redirect(array('view','id'=>$modelItem->id));
            }
        }
		
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
			'status'=>'failure',
			'div'=>$this->renderPartial('_form_item_popup', array('model'=>$modelItem), true)));
            exit;
        }
        else
		$this->render('create',array('model'=>$model,));
		
		
    }
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='acquisition-request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
