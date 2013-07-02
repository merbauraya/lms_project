<?php
require_once('File/Marc.php');
class TestController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionMarcSruXml()
	{
		$file = 'C:\Data\work\lms\z3950\sru_marcxml.xml';
		try
		{
			$bibrecords = new File_Marc($file, File_MARC::SOURCE_FILE);
		}
		catch (Exception $e) {
			print "Error: {$e->getMessage()}\n";
		}
		while ($record = $bibrecords->next()) {
			print $record;
		
		}
		//$this->render('marcxml');
	
	
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