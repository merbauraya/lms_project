<?php

class PurchaseOrderController extends Controller
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
				'actions'=>array('create','update','AddRequestItem',
				'CreateItem','updateitem','deleteitem','release','loadPoItem'),
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
	/**
	 * Release selected Purchase order
	 * PO Status will be updated to STATUS_RELEASED
	 */
	public function actionRelease()
	{
		//test wheter have required params and it is ajax request
		if (isset($_POST['ids']) && Yii::app()->request->isAjaxRequest)
		{
			$ids = $_POST['ids'];
			$sql = 'update acq_purchase_order 
			          set status_id = :status_id,
					  release_date = :release_date
					  where id in (';
			$idPlaceholder = LmUtil::sqlInConditionArrayPlaceHolder('po_id',$ids);
			$sql .= $idPlaceholder .')';
			
			//now bind all the params
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($ids);++$i)
				$cmd->bindParam(':po_id'.$i, $ids[$i],PDO::PARAM_INT);
			
			$status_id = PurchaseOrder::STATUS_RELEASED;
			$cmd->bindParam(':status_id',$status_id,PDO::PARAM_INT);
			$now = LmUtil::dbNOWexpression();
			$cmd->bindParam(':release_date',$now,PDO::PARAM_STR);
			
			try
			{
				$cmd->execute();
				echo CJSON::encode(array(
						'status'=>'success',
						'message'=>'Purchase Order released successfully ')
						);
				
			}catch (Exception $ex)
			{
				echo CJSON::encode(array(
						'status'=>'error',
						'message'=>'Error while performing the action. Log has been created '));
				LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
			}
			
		}
		else //non ajax non post
		{
			$poDP = PurchaseOrder::model()->getByStatus(PurchaseOrder::STATUS_NEW);
			$this->render('release',array('dataProvider'=>$poDP));
		}
		
	
	
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id)->with('patron');
		
		$items = new PurchaseOrderItem;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PurchaseOrder']))
		{
			$model->attributes=$_POST['PurchaseOrder'];
			
			//$model->suggested_by = Yii::app()->user->getId(); 
			if (!$model->save())
				Yii::app()->user->setFlash('error', '<strong>Error!</strong> Error saving record');
			else
				Yii::app()->user->setFlash('success','Purchase Order successfully updated');
			
				
		}
		if (isset($_POST['PurchaseOrderItem']))
		{
				$items = $_POST['PurchaseOrderItem'];
				foreach($items as $i=>$item)
					if (isset($_POST['AcquisitionRequestItem'][$i]))
					{
						$acqItem = new AcquisitionRequestItem;
						$acqItem->attributes = $_POST['AcquisitionRequestItem'][$i];
						$acqItem->save(false);	
					}
					$this->redirect(array('update','id'=>$model->id)); 
				
		}
		
		//get list of active request for this library
		
		$reqDP = AcquisitionRequestItem::model()->getApprovedItems($model->library_id);
		$poItemModel = new PurchaseOrderItem();
		$poItemDP = PurchaseOrderItem::model()->getItemByPurchaseOrder($model->id);
		
		
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
		$vendor = new Vendor('search');	
		if (isset($_GET['Vendor']))
		{
			$vendor->unsetAttributes();
			$vendor->attributes=$_GET['Vendor'];
		}
		$vendorDP = $vendor->search();	
		
		
		$this->render('update',array(
			'model'=>$model,'items'=>$items,'reqDP'=>$reqDP,'poItemModel'=>$poItemModel,'poItemDP'=>$poItemDP,'vendorDP'=>$vendorDP
		));
	}
	/**
	 * Create new Purchase order
	 * If creation is successful, the browser will be redirected to the the update * page
	 */
	public function actionCreate()
	{
		
		$model = new PurchaseOrder;
		
		/*
		if (!GenericUtils::checkAccess($operation))
		{
			throw new CHttpException(403,GenericUtils::ERROR_NO_ACCESS);
		} */
		
		if (isset($_POST['PurchaseOrder']))
		{
			$model->attributes=$_POST['PurchaseOrder'];
			$model->created_by = LmUtil::UserId();
			$model->status_id = PurchaseOrder::STATUS_NEW;
			
			
			if($model->validate() && $model->save())
			{
				
			
				//generate our PO number based on format specified
				//todo perhaps we can move this to store procedure
				//or use AR before/afterSave method
				
				$model->text_id = DocumentIdSetting::formatID($model->library_id,PurchaseOrder::DOCUMENT_TYPE,$model->id);
				if ($model->save())
				{
					
				
				Yii::app()->user->setFlash('success','Purchase Order created');
				$this->redirect(array('update',
										  'id'=>$model->id				  
										  )
									); 
				}else 
				{
					LmUtil::logError('Error assigning PO ID');	
					
				}
				
			}
			else
			{
				//error while saving
				Yii::log('Error saving Purchase order','error','PurchaseOrderController.Create');
			}
		} 
		//handle vendor lookup
		$vendor = new Vendor('search');	
		if (isset($_GET['Vendor']))
		{
			$vendor->unsetAttributes();
			$vendor->attributes=$_GET['Vendor'];
		}
		$vendorDP = $vendor->search();	
		
		
		$this->render('create',array('model'=>$model,'vendorDP'=>$vendorDP));
		
	
	
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
		$dataProvider=new CActiveDataProvider('PurchaseOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PurchaseOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PurchaseOrder']))
			$model->attributes=$_GET['PurchaseOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Add selected and approved request item to Purchase Order
	 * This is ajax + post call only
	 * Otherwise, 400 error will be thrown
	 */
	public function actionAddRequestItem()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
        {
            $itemIds = $_POST['ids'];
			$poId = $_POST['poId'];
			$poTextId = $_POST['poTextId'];
			$sql = 'update acq_request_item
			       set status_id = :status_id,
				   modified_by = :modified_by,
				   modified_date = :modified_date,
				   purchase_order_id = :po_id
				   where id in (' . LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds) .')';
			$cmd = Yii::app()->db->createCommand($sql);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
			$status = AcquisitionRequestItem::STATUS_ORDERED;
			$userID = LmUtil::UserId();
			$now = LmUtil::dBCurrentDateTime();
			$cmd->bindParam(':status_id',$status,PDO::PARAM_INT);
			$cmd->bindParam(':modified_by',$userID,PDO::PARAM_INT);
			$cmd->bindParam(':modified_date',$now,PDO::PARAM_STR);
			
			$cmd->bindParam(':po_id',$poId,PDO::PARAM_STR);
					
			
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				//start by updating suggestion item status 
				
				
				//bindParam only allow var to be passed by ref
				$user_id =Yii::app()->user->getId();
				$po_status = PurchaseOrderItem::STATUS_NEW;
				//create an entry in request item
				/*foreach ($itemIds as $itemID)
				{*/
				$sql = 'insert into acq_purchase_order_item 
						(isbn,isbn_13,title,author,
						quantity,currency_id,price,local_price,
						po_text_id,request_item_id,budget_id,
						created_by,status_id,purchase_order_id,publisher)

						select isbn,isbn_13,title,author,
						number_of_copy,	currency_id,price,local_price,
						:po_text_id,id,budget_id,
						:created_by,:item_status,:po_id,publisher
						from acq_request_item
						where id in (' . LmUtil::sqlInConditionArrayPlaceHolder('id',$itemIds) .')';
				 
				$cmd2 = Yii::app()->db->createCommand($sql);
				for ($i = 0; $i < count($itemIds);++$i)
					$cmd2->bindParam(':id'.$i, $itemIds[$i],PDO::PARAM_INT);
				
				$cmd2->bindParam(':po_text_id',$poTextId,PDO::PARAM_STR);
				$cmd2->bindParam(':created_by',$user_id,PDO::PARAM_INT);
				$cmd2->bindParam(':item_status',$po_status,PDO::PARAM_INT);
				$cmd2->bindParam(':po_id',$poId,PDO::PARAM_INT);
				$cmd->execute();
				$cmd2->execute();
					
					
				
				//}
				$transaction->commit();
				Yii::app()->user->setFlash('success','Purchase Order item successfully added');
					
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'message'=>'Purchase Order item successfully added'));
				}
				
			} catch (CDbException $ex)
			{
				$transaction->rollback();
				LmUtil::LogError('LMS DB Error '. $ex->getMessage(),$this->id . '::' . $this->action->id);
				Yii::app()->user->setFlash('error','There was an error while adding purchase order item. Log has been created');
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'error',
						'message'=>'Error adding purchase order item'));
				}
			
			}
				
			
        }
		else
		{
			//non post request
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		}
		
	
	
	}
	/**
	* Create new request item
	*
	* @param id string Purchase Order ID
	*/
		
	public function actionCreateItem($id='')
	{
        $modelItem= new PurchaseOrderItem();
        $modelItem->purchase_order_id=$id;
		
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
		
        if(isset($_POST['PurchaseOrderItem']))
        {
            $modelItem->attributes=$_POST['PurchaseOrderItem'];
            //$modelItem->po_text_id=$id;
            unset($modelItem->id); //let db generate our key
			$modelItem->status_id = PurchaseOrderItem::STATUS_NEW;
			$modelItem->created_by = LmUtil::UserId();
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
	public function actionUpdateItem($id)
	{
           $modelItem=PurchaseOrderItem::model()->findByPk($id);
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['PurchaseOrderItem']))
        {
            $modelItem->attributes=$_POST['PurchaseOrderItem'];
            if($modelItem->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'message'=>"Item successfully updated"
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
	 * Delete Purchase Order Item - This is an ajax post request
	 * If item is originated from approved request, it request status will be revert
	 * back to "Approved",otherwise it simply delete from Purchase Order Item. 
	 **/
	public function actionDeleteItem()
	{
		//todo wrap this in single sql stmt
		if(Yii::app()->request->isPostRequest && isset($_POST[
              'ids']))
		{
			$itemIds = $_POST['ids'];
			$user_id = LmUtil::UserId();
			//we need to check if item is coming from approved request
			//if so, we revert the status back to "Approved"
			//remember ids represent purchase order item id
			
			$sql = 'update acq_request_item 
					set status_id = :status_id,
					purchase_order_id = null,
					modified_by = :user_id,
					modified_date = :modified_date
					where id in 
					 (select request_item_id from acq_purchase_order_item
					  where id in (';
					  
					  //:po_item_id))';
			
			//hack where pdo bind param does not support array for
			//sql in condition
			$po_id='';
			for ($i = 0; $i < count($itemIds);++$i)
				$po_id .= ':po_id'.$i .',' ;
			$po_id .= '0'; //just append zero
			$sql .= $po_id . '))';
			Yii::trace('LM SQL='.$sql,'info');
			//now we should have param as the following format
			// where id in (:po_id1,:po_id2...etc)
			
			
			
			$status_approved = AcquisitionRequestItem::STATUS_APPROVED;
			$cmd = Yii::app()->db->createCommand($sql);
			$cmd->bindParam(':status_id',$status_approved,PDO::PARAM_INT);
			$cmd->bindParam(':user_id',$user_id,PDO::PARAM_INT);
			$cmd->bindParam(':modified_date',new CDbExpression('NOW()'),PDO::PARAM_STR);
			//now we bind the po order
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd->bindParam(':po_id'.$i, $itemIds[$i],PDO::PARAM_INT);
			
		
			//end prepare request item 
			//now prepare for deleting po item
			$sql2 = 'delete from acq_purchase_order_item
					where id in (';//;:po_item_id)';
			$sql2 .=$po_id .')';		
					
			$cmd2 = Yii::app()->db->createCommand($sql2);
			for ($i = 0; $i < count($itemIds);++$i)
				$cmd2->bindParam(':po_id'.$i, $itemIds[$i],PDO::PARAM_INT);
			
			
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				$cmd->execute();
				$cmd2->execute();
				$transaction->commit();		
				if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'message'=>"Item removed from purchase order"
                        ));
                    Yii::app()->end();               
                }else
				{
					Yii::app()->user->setFlash('info', 'Item successfuly removed from Purchase Order');
				}
				
			
			}catch (Exception $ex)
			{
				echo $ex->getMessage();
				$transaction->rollback();
				LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
			}
			
			
			
		}
              
    }
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		
		
		$model=PurchaseOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchase-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
