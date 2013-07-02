<?php

class BudgetTransactionController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','createallocation'),
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
		$model=new BudgetTransaction;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BudgetTransaction']))
		{
			$model->attributes=$_POST['BudgetTransaction'];
			$model->date_created = LmUtil::dBCurrentDateTime();
			$model->created_by = LmUtil::UserId();
			$model->budget_source_id = $model->budget_source_id==0 ? null :$model->budget_source_id;
			
			$amount = $model->trans_amount;
			$budgetId = $model->budget_account_id;
			
			//update budget account summary
			$sql = "update budget_account
					set current_balance = current_balance + :amount
					where id = :budget_id";
			
			$cmd = Yii::app()->db->createCommand($sql);
			$cmd->bindParam(':amount',$amount,null);
			$cmd->bindParam(':budget_id',$budgetId,PDO::PARAM_INT);
			
			$transaction = Yii::app()->db->beginTransaction();
			
			try
			{
				$model->save();
				$cmd->execute();
				$transaction->commit();
				LmUtil::successFlash('Transaction Created');
				$this->redirect(array('view','model'=>$model,'id'=>$model->id));
			}catch (Exception $ex)
			{
				$transaction->rollback();
				LmUtil::le($this,$ex->getMessage());
				LmUtil::errorFlash('Error creating transaction. Log has been created');
			}
			
			
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	/**
* 	Create allocation, transaction type='ALOC' in trans table
* 
*/
	public function actionCreateAllocation()
	{
		$model=new BudgetTransaction;
		$transType = BudgetTransaction::TRANS_ALLOCTION;
		if(isset($_POST['BudgetTransaction']))
		{
			$model->trans_type = BudgetTransaction::TRANS_ALLOCTION;
			$model->attributes=$_POST['BudgetTransaction'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('allocation',array(
			'model'=>$model,'trans'=>$transType,
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

		if(isset($_POST['BudgetTransaction']))
		{
			$model->attributes=$_POST['BudgetTransaction'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('BudgetTransaction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BudgetTransaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BudgetTransaction']))
			$model->attributes=$_GET['BudgetTransaction'];

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
		$model=BudgetTransaction::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='budget-transaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
