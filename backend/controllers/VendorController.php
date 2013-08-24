<?php

class VendorController extends Controller
{
	
	
	
	public function actionIndex()
	{
		$this->render('index');
	}
	/**
	*   Return list of vendor for select2 dropdown   
	*   with id equal to vendor code
	*
	*/
	public function actionAjaxGetVendor()
	{
		if (isset($_GET['q'])) {
			$vdr = Vendor::model()->findAll(array('order'=>'code', 
												'condition'=>'code LIKE :code', 
												'params'=>array(':code'=>$_GET['q'].'%'),
												'limit'=>$_GET['page_limit']
												));
			$data = array();
			foreach ($vdr as $value) {
				$data[] = array(
				'id' => $value->code,
				'text' => $value->code .' :: ' .$value->name,
				);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
		
	}
    public function actionSearch()
    {
        $model=new Vendor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vendor']))
			$model->attributes=$_GET['Vendor'];

		
        
        
    }
	public function actionAjaxGetVendorList()
	{
		//check whether we return code or id
		$id = isset($_GET['ret']) ? $_GET['ret'] : 'id';
	
		
		if (isset($_GET['q'])) {
			$vdr = Vendor::model()->findAll(array(
					'select'=>'id,code,name',
					'order'=>'code', 
					'condition'=>'code LIKE :code', 
					'params'=>array(':code'=>$_GET['q'].'%'),
					'limit'=>$_GET['page_limit'],
				));
			$data = array();
			foreach ($vdr as $value) {
				$data[] = array(
				'id' => $value->$id,
				'text' => $value->code .' :: ' .$value->name,
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
