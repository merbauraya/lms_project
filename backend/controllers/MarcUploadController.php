<?php
//Yii::import('application.vendors.PEAR.*');
require_once('File/MARC.php');
class MarcUploadController extends Controller
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
		$model=new MarcUpload;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MarcUpload']))
		{
			$model->attributes=$_POST['MarcUpload'];
			$uploadedFile=CUploadedFile::getInstance($model,'filename');
			$model->filename = $uploadedFile->name;
			$model->upload_date = date('Y-m-d H:i:s');
			if($model->save())
				$fullFilePath = Yii::getPathOfAlias('webroot.protected.upload.marcupload').DIRECTORY_SEPARATOR.$uploadedFile->name;
				$uploadSuccess = $uploadedFile->saveAs($fullFilePath);
				if (!$uploadSuccess)
				{
					throw new CHttpException('Error uploading file.'); 
				}
				$this->readMarc($fullFilePath);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	private function readMarc($filename)
	{
		$authorID=0;
		$biblioID=0;
		$importedRecord = 0;
		$marc_source = new File_MARC($filename);
		
		while ($record = $marc_source->next())
		{
			//
			$biblio = new Biblio; //our biblio AR
			//get title
			$title_fld = $record->getField('245');			
			$title_main = $title_fld->getSubFields('a');
			$title = $title_main[0]->getData();
			//subtitle
			$subtitle = $title_fld->getSubfields('b');
			if (isset($subtitle[0]))					
				$title = $subtitle[0]->getData();
			$biblio->title = $title;
			
			//ISBN
			$biblio->isbn_issn = $this->getISBN_ISSN($record);
			$biblio->date_created = date('Y-m-d H:i:s');
			$biblio->date_updated = date('Y-m-d H:i:s');
			if ($biblio->save())
			{
				$importedRecord++;
				$biblioID = $biblio->id;
			}
			//get author and create new author record
			$author = $record->getFields('100');
			if ($author)
			{
				$aname = $author->getSubFields('a');
				if (isset($aname[0]))
				{
					$authorID = ARUtil::getAuthorID($aname[0]);	
					
				}
			}

			//create new biblio_author entry
			$bib_aut = new BiblioAuthor;
			$bib_aut->biblio_id = $biblioID;
			$bib_aut->author_id = $authorID;
			$bib_aut->date_created = date('Y-m-d H:i:s');
			$bib_aut->date_updated = date('Y-m-d H:i:s');
			

		} //marc_source->next
	}
	private function getISBN_ISSN($record)
	{
		
		$ISBN_ISSN='';	
		// Identifier - ISBN
		        
		$id_fld = $record->getField('020');
        if ($id_fld) {
          $isbn_issn = $id_fld->getSubfields('a');
          if (isset($isbn_issn[0])) {
            // echo "\n"; echo 'ISBN/ISSN: '.$isbn_issn[0]->getData();
            $ISBN_ISSN = $isbn_issn[0]->getData();
          }
        }

        // Identifier - ISSN
        $id_fld = $record->getField('022');
        if ($id_fld) {
          echo "\n";
          $isbn_issn = $id_fld->getSubfields('a');
          if (isset($isbn_issn[0])) {
            // echo 'ISBN/ISSN: '.$isbn_issn[0]->getData();
            $ISBN_ISSN = $isbn_issn[0]->getData();
          }
        }
		return $ISBN_ISSN;

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

		if(isset($_POST['MarcUpload']))
		{
			$model->attributes=$_POST['MarcUpload'];
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
		$dataProvider=new CActiveDataProvider('MarcUpload');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MarcUpload('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MarcUpload']))
			$model->attributes=$_GET['MarcUpload'];

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
		$model=MarcUpload::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='marc-upload-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
