<?php

class InvoiceController extends Controller
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
				'actions'=>array('create','update'),
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
		$model=new Invoice;
		$operation = 'addInvoice';
		
		$session = Yii::app()->session;
		//$session['isQuote'] = Invoice::DOC_QUOTATION;
		if (isset($_POST['Invoice']))
		{
			$model->attributes=$_POST['Invoice'];
			$model->created_by = LmUtil::UserId();
			$model->status_id = Invoice::STATUS_DRAFT;
			
			
			
			if($model->validate() && $model->save())
			{
				
				//$model->invoice_no = DocumentIdSetting::formatID($model->library_id,Invoice::DOCUMENT_TYPE,$model->id);
				//$model->save();
				Yii::app()->user->setFlash('success','Invoice successfully created');
				$this->redirect(array('update',
				'id'=>$model->id				  
				)
				); 
			}
			else
			{
				//error while saving
				Yii::log('Error saving Invoice','error',$this->id . '::' . $this->action->id);
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
		
		//handle po lookup
		$po = new PurchaseOrder();
		if (isset($_GET['PurchaseOrder']))
		{
			$po->unsetAttributes();
			$po->attributes=$_GET['PurchaseOrder'];
			$po->status_id=PurchaseOrder::STATUS_RELEASED;
		}
		$poDP = $po->search(array('vendor'));
		$this->render('create',array('model'=>$model,'vendorDP'=>$vendorDP,'poDP'=>$poDP));
	}
	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id)->with('vendor');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Invoice']))
		{
			$model->attributes=$_POST['Invoice'];
			if($model->save())
				Yii::app()->user->setFlash('success','Invoice successfully updated');
		}
		//handle vendor lookup
		$vendor = new Vendor('search');	
		if (isset($_GET['Vendor']))
		{
			$vendor->unsetAttributes();
			$vendor->attributes=$_GET['Vendor'];
		}
		$vendorDP = $vendor->search();
		
		$po = new PurchaseOrder();
		$po->text_id = $model->po_text_id;
		$poDP = $po->search(array('vendor'));
			
		//handle po lookup
		$poItem = new PurchaseOrderItem();
		$poItem->po_text_id = $model->po_text_id;
		if (isset($_GET['PurchaseOrderItem']))
		{
			$poItem->unsetAttributes();
			$poItem->attributes=$_GET['PurchaseOrderItem'];
			//$po->po_text_id = $model->text_id;
			$po->status_id = PurchaseOrder::STATUS_RELEASED;
		}
		$poItemDP = $poItem->search();
		
		$this->render('update',array(
			'model'=>$model,'vendorDP'=>$vendorDP,'poDP'=>$poDP,'poItemDP'=>$poItemDP
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
	 * Render Purchase Order Item based on the given PO id
	 *
	 * @param string the ID of the Purchase order Item to be loaded
	 */
	public function actionLoadPoItem($id)
	{
		
		$criteria = new CDbCriteria(); 
		$criteria->condition = 'purchase_order_id= :id and status_id = :status';
		
		$criteria->params = array(':id'=>$id,':status'=>AcquisitionSuggestionItem::ITEM_STATUS_NEW); 
		
		$itemsDP=new CActiveDataProvider( 'PurchaseOrderItem', array( 'criteria' => $criteria, 'pagination' => array( 'pageSize' => '20', ) ) );
		
		//prevent the following script to be re-rendered
		if (Yii::app()->request->isAjaxRequest){
			Yii::app()->clientscript->scriptMap['jquery.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.js'] = false; 
			Yii::app()->clientscript->scriptMap['bootstrap.bootbox.min.js'] = false; 
			Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false; 
		}
		
		$this->renderPartial('_po_item_list',array('itemsDP'=>$itemsDP),false,true);
		
		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Invoice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Invoice']))
			$model->attributes=$_GET['Invoice'];

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
		$model=Invoice::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
