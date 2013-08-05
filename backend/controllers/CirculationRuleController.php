<?php

class CirculationRuleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			array('auth.filters.AuthFilter'),
            //'accessControl', // perform access control for CRUD operations
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
		$model=new CirculationRule;
        $model->library_id = LmUtil::UserLibraryId();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CirculationRule']))
		{
			$model->attributes=$_POST['CirculationRule'];
            if ($model->patron_category_id ==0)
                unset($model->patron_category_id);
            if ($model->item_category_id ==0)
                unset($model->item_category_id);
			if($model->validate() && $model->save())
			{
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['CirculationRule']))
		{
			$model->attributes=$_POST['CirculationRule'];
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
		$dataProvider=new CActiveDataProvider('CirculationRule');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CirculationRule('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CirculationRule']))
			$model->attributes=$_GET['CirculationRule'];

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
		$model=CirculationRule::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='checkout-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    /**
     * Render Loan Period in admin grid
     * 
     * 
     */ 
    protected function renderLoadPeriod($data,$row)
    {
        $buf = $data->loan_period;
        switch ($data->period_type)
        {
            case CirculationRule::PERIOD_DAY:
                $buf .= ' (days)';
                break;
            case CirculationRule::PERIOD_HOUR:
                $buf .= ' (hours)';
                break;
        }
        echo $buf;
    }
    /**
     * Render hard due in admin grid
     * 
     */
     protected function renderHardDue($data,$row)
     {
         switch ($data->hard_due)
         {
            case CirculationRule::HARD_DUE_NA:
                echo 'N/A';
                break;
            case CirculationRule::HARD_DUE_BEFORE_LIBRARY_CLOSE:
                echo 'Before closing';
                break;
            case CirculationRule::HARD_DUE_AFTER_LIBRARY_OPEN:
                echo 'After re-opening';
                break;
         }
                
         
     }
     /*
      * Return default rule based on the request type
      * If it's an ajax request, check the "ret" parameter to determine data format to return
      * 
      */ 
     public function actionGetDefault()
     {
         $sql = 'select * from cir_rule
                 where library_id=:id
                 and smd_id is null
                 and patron_category_id is null
                 and item_category_id is null';
         
         $result = Yii::app()->db->createCommand($sql)->query(array(':id'=>LmUtil::UserLibraryId()))->readAll();
         
         
         //$cmd->bindValue(':id',LmUtil::UserLibraryId(),PDO_PARAM_INT);
         /*
         $rule = CirculationRule::model()->find(
                    'library_id=:id and smd_id is null
                     and patron_category_id is null
                     and item_category_id is null',
                     array(':id'=>LmUtil::UserLibraryId())
         
         );*/
         //$data = array();
     
         if (Yii::app()->request->isAjaxRequest)
         {
             $ret = isset($_GET['ret']) ? $_GET['ret'] : 'json';
             if ($ret == 'json')
             {
                 $buffer = array();
                 $buffer['exist']= count($result)>0 ;
                 $buffer['default'] = $result;
                 echo CJSON::encode($buffer);
             }
             
         }
         
         
     }
}
