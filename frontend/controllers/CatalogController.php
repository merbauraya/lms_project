<?php
require_once('File/Marc.php');
class CatalogController extends Controller
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
				'actions'=>array('create','update','parseMarc','ParseMarcBrief','ParseMarcFull','saveMarc','UploadMarc','RenderCatalogTemplate'),
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
		$model=new Catalog;
		
		if (isset($_POST['saveMarc'])) //process Marc
		{
			$marc_data = $_POST['marcData'];
			$bib = new File_Marc($marc_data, File_MARC::SOURCE_STRING);
			while ($record = $bib->next()) 
			{
				$tag245 = $record->getField('245');
				$_245 = MarcTag::getMarc245Data($tag245);	
			}
		}//end process Marc
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
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

		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
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
	public function actionRenderCatalogTemplate()
	{
		if (!isset($_POST['catalogTemplate']))
			return;
		
		try 
		{
			$templateID = $_POST['catalogTemplate'];
			$catalogTemplate = CatalogTemplateTag::model()->loadByTemplateID($templateID);
			$this->renderPartial('_addCatalog',array('templates'=>$catalogTemplate));
		}
		catch (CExption $e)
		{
			Yii::app()->user->setFlash('error', 'Template not found');
		}
			
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Catalog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Catalog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Catalog']))
			$model->attributes=$_GET['Catalog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionUploadMarc()
	{
	//	print_r($_POST);
	//	print_r($_FILES);
		if(isset($_POST['saveMarcRecord']))
		{
			$this->actionSaveMarc();
		}
		
		if (isset($_POST['MarcUpload']))
		{
		//			print_r($_POST);
			//print_r($_FILES);
			//var_dump($_FILES);
			$fileName =  $_FILES['MarcUpload']['name'][0];
			$fileTmpLoc = $_FILES['MarcUpload']['tmp_name'][0];
			$fullFilePath = Yii::getPathOfAlias('webroot.protected.upload.marc').DIRECTORY_SEPARATOR.$fileName;
			$moveResult = move_uploaded_file($fileTmpLoc,$fullFilePath);
			if ($moveResult)
			{
				//echo "<div id='filename'>$fileName</div>";
				$fileMarc = new File_MARC($fullFilePath);
					//$this->readMarc($fullFilePath);
					
				$this->renderPartial('_editMarc',array('marc'=>$fileMarc));
			}
			
		
		}
		
	
	}
	public function actionParseMarc()
	{
		$marc_data='';
		
		if(isset($_POST['marcData']))
		{
			$marc_data = $_POST['marcData'];
			$bib = new File_Marc($marc_data, File_MARC::SOURCE_STRING);
			while ($marc_record = $bib->next()) {
				
				print '<p>'.$marc_record->getLeader().'</p>';
				$fields = $marc_record->getFields();
  
				foreach ($fields as $field) {
					print '<p>'.$field;
					print "</p>";
    
				}
			}
		}
	
	
	}
	/**
	*saveMarc 
	*
	*  
	*/
	public function actionSaveMarc()
	{
		//if form is not submitted we render detail form
		//with marc data
		if(isset($_POST['marcData']))
		{
			$atmp = array();
			$marc_data = $_POST['marcData'];
			$fileMarc = new File_Marc($marc_data, File_MARC::SOURCE_STRING);
			$this->renderPartial('_editMarc',array('marc'=>$fileMarc));
			return;
		}
		
		//user attempts to save edited marc
		if(isset($_POST['saveMarcRecord']))
		{
	
			$transaction =  Yii::app()->db->beginTransaction();
			try {
				
			
				$m = new MarcActiveRecord($_POST['Marc']);
				//we create the basic catalog to get the id
				$catalog = $this->addNewCatalog($m,Catalog::SOURCE_MARC_IMPORT);
				$catalog->setIsNewRecord(FALSE);
				
				$catalog_id = $catalog->id;
				//loop all field subfield in our marc and grab what we looking for
				
				$marc = $m->Marc;
				
				//while ($marc_record = $marc->next())
				//{
				$data = array();	
				$fields = $marc->getFields();
				$_personalname = new PersonalName();
				foreach($fields as $field)
				{
					//print $field->getTag();
					
					if ($field->isDataField()) {
					$subfields = $field->getSubFields();
					//print "\n";
					foreach($subfields as $subfield)
					{
						Yii::trace('<p>field='.$field->getTag(). ' subfield='.$subfield->getCode() . $subfield->getData(). '</p>','trace','marc');
						switch (trim($field->getTag()))
						{
							case '245': //title
								switch (trim($subfield->getCode()))
								{
									case 'a' : //245_a main title
										$catalog->title_245a = $subfield->getData();
										
										break;
									case 'b' : //245_b sub title
										$catalog->title_245b = $subfield->getData();
										
										break;
									case 'c' : //245_c SOR
										$catalog->title_245c = $subfield->getData();
										
										break;
								}
								break;
							
							case '100': // personal name
								switch ($subfield->getCode())
								{
									case 'a': //100_a
										//$_100a = $subfield->getData();
										$_personalname->name = $subfield->getData();
										break;
									case 'b': //100_b numeration	
										//$_100b = $subfield->getData();
										$_personalname->numeration=$subfield->getData();
										break;
									case 'c': //100_c title_word_associated
										$_100c = $subfield->getData();
										$_personalname->title_word=$subfield->getData();
										break;	
									case 'd': //100_d date associated
										//$_100d = $subfield->getData();
										$_personalname->date_associated=$subfield->getData();
										break;
								}		
								break;
							 case '260' : //publication INFO_ALL
							 	switch ($subfield->getCode())
								{
									case 'a': //260_a publication place
										//$data['260a']
										//$catalog-> .= $subfield->getData();
										break;
									case 'b': //260_b publisher name
										//$_260b .= $subfield->getData();
										$publisher_id = Publisher::model()->getIDByName($subfield->getData());
										$catalog->publisher.=$subfield->getData();
										break;
									case 'c': //260_c publication date
										//$_260c .= $subfield->getData();
										$catalog->year_publish = $subfield->getData();
										break;
								}
								break;
							case '651':
							case '648':
							case '655':
							case '656':
							case '657':
							case '650' : //topical term
								if ($subfield->getCode() == 'a'){
									
								
									$_650a = $subfield->getData();
									$subject_id = Subject::model()->getIDByName($_650a);
									CatalogSubject::model()->addNewRecord($catalog_id,$subject_id);
									
								}
								break;
									
								
							break;
						}
						//print $field->getTag().'-'.$subfield->getCode().'-'.$subfield->getData() ;
						//print "\n";
					}
					}
				}
				//}
				
				if (isset($_personalname->name)) 
				{
					$personal_name_id = $_personalname->isExistByName();
					$catalog->personal_name_id = $personal_name_id;
				}
				//remove non number
				//$catalog->year_publish = preg_replace('/\D/', '', $catalog->year_publish);
				$catalog->marc_xml = $marc->toXML('UTF-8',true,true);
				$catalog->marc_data = $marc->toRaw();
				$catalog->update();
				$transaction->commit();
				
				Yii::app()->user->setFlash('success', 'Bibliograpy record has been saved successfully.');
			}
			catch (CException $e)
			{
				$transaction->rollBack();
				Yii::app()->user->setFlash('error','<strong>Error!</strong> Error while saving bibliographic record.'. $e->getMessage());
				echo 'Error!!!'.$e->getMessage();
			}
			
			
	
			
			//$this->render('create',array('model'=>$model));
			
		}else
		{
			//no data submit we simply ignore
		}
		$this->render('create');
		
	}
	private function addNewCatalog($marc,$source)
	{
		$catalog = new Catalog();
		$catalog->source = $source;
		$catalog->save();
		return $catalog;
		
	}
	public function actionParseMarcFull()
	{
		
		if(isset($_POST['marcData']))
		{
			$atmp = array();
			$marc_data = $_POST['marcData'];
			$bib = new File_Marc($marc_data, File_MARC::SOURCE_STRING);
			$marc = new MarcRecord($bib);
			
			
			
		}
		$tpTerm = $marc->getTopicalTerm();
		$topicalTerm=array();
		$tpCount=0;
		foreach($topicalTerm as $key=>$value)
		{
			$tpCount++;
			$topicalTerm['topicalterm'.$tpCount] = $value;
		}
		$data = array(
				'title' => $marc->getFullTitle(),
				'personal_name'=>$marc->getPersonalName(),
				'edition'=>$marc->getEdition(),
				'publish'=>$marc->getPublicationInfo(),
				'physical_info'=>$marc->getPhysicalInfo(),
				'isbn'=>$marc->getISBN(),
				'note'=>$marc->getNote(),
				'lc_classification'=>$marc->getLCClassification(),
				'dewey'=>$marc->getDeweyClassification(),
				'geog_code'=>$marc->getGeographyAreaCode(),
				
			);
		$fullData = $data +$topicalTerm;
		$this->renderPartial('_marcFullView',array('data'=>$fullData,'tpCount'=>$tpCount));
	}
	public function actionParseMarcBrief()
	{
	$marc_data='';
		
		if(isset($_POST['marcData']))
		{
			$marc_data = $_POST['marcData'];
			$bib = new File_Marc($marc_data, File_MARC::SOURCE_STRING);
			while ($marc_record = $bib->next()) {
				$ldr = $marc_record->getLeader();
				$fields = $marc_record->getFields();
  
				foreach ($fields as $field) {
					print '<p>'.$field;
					print "</p>";
    
				}
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
		$model=Catalog::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
