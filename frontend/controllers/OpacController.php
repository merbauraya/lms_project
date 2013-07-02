<?php
Yii::import('application.vendors.*');
require_once('Sphinx/sphinxapi.php');
class OpacController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout='//layouts/column1';
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->layout = 'opac';
		
		Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully read this important alert message.');
		
		
		if (!isset($_GET['q'])){
			
			
			$this->render('index');
			//$this->redirect(array('opac/index'));
			//echo 'xxx';
			return;
		}
		$q = $_GET['q'];
		//$cat = $_GET['cat'];
		//echo $q.$cat;
		if (!$q)
		{
			Yii::app()->user->setFlash('info', "You did not enter search word!");
			$this->render('index',array('msg'=>'You did not enter search word'));
			return;
		}
		
		//SphinxSearch criteria
        $searchCriteria = new stdClass();
        $searchCriteria->select = '*';
        $searchCriteria->query = ''.$q.'';
        $searchCriteria->from = '*';
		$num=10;
		
		//Yii AR criteria
		$criteria = new CDbCriteria;
		$criteria->select = 'id,title_245a,title_245b,title_245c,publisher,year_publish';
        //$criteria->with = array('brand','category');
        //...
        $catalog = new SphinxDataProvider('Catalog',
                array(
                        'criteria' => $criteria, //criteria for AR model
                        'sphinxCriteria' => $searchCriteria, //SphinxSearch critria
                        'pagination'=>array(
                                'pageSize' => $num,
                                'pageVar' => 'p',
                        ),/*
                        'sort' => array(
                                'attributes'=>array(
                                        'price'=>array(
                                                'asc' => 'price ASC',
                                                'desc' => 'price DESC',
                                        ),
                                        'title'=>array(
                                                'asc' => 'title ASC',
                                                'desc' => 'title DESC',
                                        ),
                                ),
                        ),*/
        ));
		$this->render('index',array('dataProvider'=>$catalog));
	}

	
	/**
	 * Displays the search result
	 */
	public function actionSearch()
	{
		
		//$this->layout = 'opac';
		if (isset($_GET['q']))
		{
		
			$q = $_GET['q'];
			print_r($_GET);
		}
		else
		{
			return;
		}
			
		
		//SphinxSearch criteria
        $searchCriteria = new stdClass();
        $searchCriteria->select = '*';
        $searchCriteria->query = ''.$q.'';
        $searchCriteria->from = 'search_catalog';
		//...
        //$filters['brand_id'] = $brands_array; //filter by brand ids, if needed
        //if(!empty($filters)) $searchCriteria->filters = $filters;
        //...
        //items criteria
        $num=10;
		$criteria = new CDbCriteria;
        //$criteria->with = array('brand','category');
        //...
        $catalog = new SphinxDataProvider('SearchCatalog',
                array(
                        'criteria' => $criteria, //criteria for AR model
                        'sphinxCriteria' => $searchCriteria, //SphinxSearch critria
                        'pagination'=>array(
                                'pageSize' => $num,
                                'pageVar' => 'p',
                        ),/*
                        'sort' => array(
                                'attributes'=>array(
                                        'price'=>array(
                                                'asc' => 'price ASC',
                                                'desc' => 'price DESC',
                                        ),
                                        'title'=>array(
                                                'asc' => 'title ASC',
                                                'desc' => 'title DESC',
                                        ),
                                ),
                        ),*/
        ));
		
		//$this->render('index',array('dataProvider'=>$catalog));
	}
/**
* This function does the actual rendering for opac search based gridview column
* @param undefined $data
* @param undefined $row
* 
*/
	protected function gridOpacResult($data,$row)
	{
		$this->renderPartial('_catalogItem',array('row'=>$row,'data'=>$data));
		//var_dump($row);	
	}

	
}