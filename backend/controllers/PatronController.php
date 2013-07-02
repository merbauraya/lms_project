<?php

class PatronController extends Controller
{
	public $layout='//layouts/column2';
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	public function accessRules()
	{
		return array(
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('received','update','create','ajaxgetpatron'),
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
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionCreate()
	{
		$model = new Patron();
		$this->render('create',compact('model'));
	
	}
	/**
	*	Return list of users based on given params.
	*   Note that this should only be called via ajax
	*   Params get are:
	*   1. q - The search term
	*   2. lib - Library to search for
	*   3. ret - What will be returned as id. If value is uname, username will be returned, 
	*            otherwise ID will be returned instead.
	*   
	*/
	public function actionAjaxGetPatron()
	{
		if (isset($_GET['q'])) {
			
			$vdr = Patron::model()->findAll(array('order'=>'username', 
												'condition'=>'username LIKE :username and library_id=:library', 
												'params'=>array(':username'=>$_GET['q'].'%',
															    ':library'=>$_GET['lib']),
												'limit'=>$_GET['page_limit']
												));
			$data = array();
			foreach ($vdr as $value) {
				$data[] = array(
				'id' => $_GET['ret']=='uname' ? $value->username : $value->id,
				'text' => $value->username. '::' .$value->name,
				'status' => $value->status_id,
				);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	
	
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