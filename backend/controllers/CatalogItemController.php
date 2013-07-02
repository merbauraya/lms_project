<?php

class CatalogItemController extends Controller
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
				'actions'=>array('create','update','ajaxgetitem'),
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
		
		$criteria = new CDbCriteria();
		$criteria->condition = 't.id = :id';
		$criteria->params = array(':id'=>$id);
		$criteria->with = array('category','catalog','location');
		$model = CatalogItem::model()->find($criteria);
		
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CatalogItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogItem']))
		{
			
			$model->attributes=$_POST['CatalogItem'];
			$model->date_acquired = LmUtil::dBCurrentDateTime();
			if ($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();
				try
				{
					$model->save();
					$model->accession_number=DocumentIdSetting::formatID(0,DocumentIdSetting::ITEM_ACCESSION_NO,$model->id);
					$model->save();
					$transaction->commit();
					Yii::app()->user->setFlash('success','Accession successfully created');
					$this->redirect(array('view','id'=>$model->id));
				} catch (Exception $ex)
				{
					$transaction->rollback();
					LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
				
				}
			}else
			{
				
			}
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

		if(isset($_POST['BiblioItem']))
		{
			$model->attributes=$_POST['BiblioItem'];
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
	public function actionAjaxGetItem()
	{
		if (isset($_GET['q'])) {
			
			$vdr = CatalogItem::model()->findAll(array('order'=>'accession_number', 
												'condition'=>'owner_library=:library and accession_number LIKE :accession', 
												'params'=>array(':accession'=>$_GET['q'].'%',
															    ':library'=>$_GET['lib']),
												'with'=>array('catalog'),				
												'limit'=>$_GET['page_limit']
												));
			$data = array();
			foreach ($vdr as $value) {
				$data[] = array(
				'id' => $_GET['ret']=='accession' ? $value->accession_number : $value->id,
				'text' => $value->accession_number. '::' .$value->catalog->title_245a,
				);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	
	
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BiblioItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BiblioItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BiblioItem']))
			$model->attributes=$_GET['BiblioItem'];

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
		$model=CatalogItem::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='biblio-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
