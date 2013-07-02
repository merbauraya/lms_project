<?php

class GoodReceiveController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','LoadPoItem','receiveItem','deleteItem'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new GoodReceive;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GoodReceive']))
		{
			$model->unsetAttributes();
			$model->attributes=$_POST['GoodReceive'];
			$model->created_by = LmUtil::UserId();
			$model->date_created = LmUtil::dBCurrentDateTime();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GoodReceive']))
		{
			$model->attributes=$_POST['GoodReceive'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$poList = PurchaseOrder::model()->getPoByVendor($model->vendor_code);
		
		$this->render('update',array(
			'model'=>$model,'poList'=>$poList
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
		$dataProvider=new CActiveDataProvider('GoodReceive');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GoodReceive('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GoodReceive']))
			$model->attributes=$_GET['GoodReceive'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/*
	 * 
	 * 
	 * @param integer ID of the Purchase Order
	 */ 
	public function actionLoadPoItem($id)
	{
		//get our goods receiving id
		$x = Yii::app()->config->get('TEST2');
		Yii::app()->config->set('TEST2','Test 2 ajexxx');
		if(!isset($_GET['rID']))
			throw new CHttpException(400,'Internal error.Params not set');
		else
			$rID = $_GET['rID'];
			
		$itemsDP = PurchaseOrderItem::model()->getReleasedNonClosedItem($id);
		if (Yii::app()->request->isAjaxRequest){
			Yii::app()->clientscript->scriptMap['jquery.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.min.js'] = false; 
			//Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false; 
			//Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.bootbox.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['*.css'] = false; 
			//Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false; 
		}
		//build our received item
		$rcvdDP = GoodReceiveItem::model()->getByGoodReceiveID($rID);
		$this->renderPartial('_po_item_list',array('itemsDP'=>$itemsDP,'rID'=>$rID,'rcvdDP'=>$rcvdDP),false,true);
		
	}
	/**
	 * Show receive item dialog
	 * @param integer the ID of the purchase order item
	 * 
	 */
	public function actionReceiveItem($id)
	{
		$model=new GoodReceiveItem();
		$rID = $_POST['rID'];
		
		
		
		
		if (Yii::app()->request->isAjaxRequest){
			Yii::app()->clientscript->scriptMap['jquery.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.bootbox.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false;
			
		}
		if(isset($_POST['GoodReceiveItem']))
        {
            $poItem = PurchaseOrderItem::model()->findByPk($id);
			$model->unsetAttributes();
			$model->attributes=$_POST['GoodReceiveItem'];
			$model->po_item_id = $id;
			$model->good_receive_id = $rID;
			$model->date_created = LmUtil::CurrentDate();
			//update po item status accordingly
			if ($model->quantity_received = $poItem->quantity)
				$poItem->status_id = PurchaseOrderItem::STATUS_DELIVERY_COMPLETED;
			else
				$poItem->status_id = PurchaseOrderItem::STATUS_PARTIAL_DELIVERED;
			$poItem->quantity_received = $model->quantity_received;
			$poItem->modified_date = LmUtil::CurrentDate();
			$poItem->date_received = LmUtil::CurrentDate();
			$poItem->modified_date = LmUtil::CurrentDate();
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				$model->save();
				$poItem->save();
				$trans->commit();
				if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'_',		
					'message'=>"Item successfully updated"
					));
                    exit;               
                }
                else
				$this->redirect(array('view','id'=>$modelItem->id));
				
			}catch (Exception $ex)
			{
				$trans->rollback();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					'status'=>'error', 
					'message'=>"Error updating item. Log has been created"
					));
                    exit; 	
				}
			}
            
        } //isset($_POST['GoodReceiveItem']
		
		
		$poModel = PurchaseOrderItem::model()->findByPk($id);
		$model->good_receive_id = $rID;
		$model->quantity_to_receive = $poModel->quantity;
		$model->budget_id = $poModel->budget_id;
		$model->price = $poModel->price;
		$model->local_price = $poModel->local_price;
		if (Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
			'status'=>'failure', 
			'div'=>$this->renderPartial('_receiveDialog',array('model'=>$model,'rID'=>$rID),true)));
            exit;   
		}
		//$this->renderPartial('_receiveDialog',array('model'=>$model),false,true);
		
	}
	/**
	 * Delete good receive item
	 * @param  integer the ID of the item to be deleted
	 */ 
	public function actionDeleteItem($id)
	{
		$grItem = GoodReceiveItem::model()->findByPk($id);
		$poItem = PurchaseOrderItem::model()->findByPk($grItem->po_item_id);
		//update our po status back
		$poItem->quantity_received = $poItem->quantity_received-$grItem->quantity_received;
		$po_status = $poItem->quantity_received == 0 ? PurchaseOrderItem::STATUS_RELEASED : PurchaseOrderItem::STATUS_PARTIAL_DELIVERED;
		
		$trans = Yii::app()->db->beginTransaction();
		try
		{
			$grItem->delete();
			$poItem->save();
			$trans->commit();
			echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>"Item Deleted"
				)
			);			
		}catch (Exception $ex)
		{
			$trans->rollback();
			LmUtil::le($this,$ex->getMessage());
			echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>"Error deleting item. Log has been created"
			));		
		}
		
		
		
		
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GoodReceive::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='good-receive-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
