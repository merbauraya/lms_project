<?php
//Yii::import('application.vendors.PEAR.*');
require_once('File/MARC.php');
require_once('File/MARCXML.php');
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
			array('auth.filters.AuthFilter - login, logout, restore, captcha, error'),
            //'accessControl', // perform access control for CRUD operations
		);
	}

	

	
    
    public function actionUpload()
    {
        $model = new MarcUpload();
        
        if (isset($_POST['MarcUpload']))
        {
            if( Yii::app( )->user->hasState( 'upload' ))
                $uploaded = Yii::app()->user->getState('upload');
            else
                throw new CHttpException(500,'Server error while processing upload');
            $model->attributes = $_POST['MarcUpload'];
            $model->library_id = LmUtil::UserLibraryId();
            $model->uploaded_by = LmUtil::UserId();
            $model->date_created = LmUtil::dBCurrentDatetime();
            $model->full_path = $uploaded['path'];
            $model->file_name = $uploaded['name'];
            $model->save();
            
            if (isset($_POST['processNow']))
            {
                $this->actionStagedUploaded($model);
                $this->redirect(array('ShowUploadSummary','id'=>$model->id));
            }
            if (isset($_POST['processLater']))
                $this->actionStagedUploaded($model);
                
            return;
            
        }
        $xupload = new XUploadForm;
        $this->render( 'upload', array(
            'model' => $model,
            'xupload' => $xupload,
    ) );
        
    }
    public function actionShowUploadSummary($id)
    {
        
        //get upload info
        $upload = MarcUpload::model()->findByPk($id);
        if (!$upload)
            throw new CHttpException(404,'Requested document cannot be found');
        if ($upload->process_date != null)
            throw new CHttpException(404,'Requested document cannot be found');
                
        $criteria = new CDbCriteria();
		$criteria->condition = 'marc_upload_id= :id';
		$criteria->params = array(':id'=>$id);
		$itemDP=new CActiveDataProvider(
			'MarcUploadItem',
			array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => '20',
				)
			)
		);
               
		
		$this->render('uploadsummary',array(
			'model'=>$upload,'itemDP'=>$itemDP,
		));
        
    }
    /**
     * Process uploaded file
     * @params model - MarcUpload model
     * 
     * 
     */ 
    
    private function actionProcessUploadedFile($model)
    {
        $file = $model->full_path;
        
        $marcFile = new File_MARC($file);
        
        $recCount=0;
        $transaction =  Yii::app()->db->beginTransaction();
        
        try
        {
            while ($record = $marc->next()) 
            {
                $recCount++;
                $uploadItem = new MarcUploadItem();
                $uploadItem->marc_upload_id = $model->id;
                $uploadItem->marc_xml = $record->toXML();
                $uploadItem->save();
            }
            $transaction->commit();
        }catch (CException $e)
        {
            $transaction->rollback();
        
        }
        
        
        
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



	
	/*
     * Handle Marc upload process. After file has been uploaded
     * it will be moved to a upload folder for later processing.
     * New record entry in MarcUpload model will also be created
     */
	public function actionHandleUpload()
	{
		//Here we define the paths where the files will be stored 

		$path = realpath(Yii::getPathOfAlias('uploadMarc'));
		$path .= DIRECTORY_SEPARATOR;
		//$publicPath = Yii::app( )->getBaseUrl( )."/images/uploads/tmp/";
	 
		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] ) 
			&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}
        
		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				if( $_GET["file"][0] !== '.' ) {
					$file = $path.$_GET["file"];
					if( is_file( $file ) ) {
						unlink( $file );
					}
				}
				echo json_encode( true );
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//We check that the file was successfully uploaded
			if( $model->file !== null ) 
            {
				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );
				if( $model->validate() ) 
                {
					//Move our file to our upload folder
					$model->file->saveAs( $path. $model->name);//$filename );
					chmod( $path.$model->name, 0777 );
					
	 
					//Now we need to save this path to the user's session
					/*if( Yii::app( )->user->hasState( 'upload' ) ) {
						$userImages = Yii::app( )->user->getState( 'upload' );
					} else {
						$userImages = array();
					}*/
                    //we allow single file upload, always refresh user session
                    //with current upload info
					 $userImages = array(
						"path" => $path.$model->name,// $filename,
						//the same file or a thumb version that you generated
						"thumb" => $path.$filename,
						//"filename" => $filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name,
						'imported'=>0
					);
                    //save our uploaded info
                    /*
                    $upload = new MarcUpload();
                    $upload->file_name = $model->name;
                    $upload->full_path = $path.$model->name;
                    $upload->uploaded_by = LmUtil::UserId();
                    $upload->date_created = LmUtil::dBCurrentDatetime();
                    $upload->library_id = LmUtil::UserLibraryId();
                    $upload->upload_type = $uploadType;
                    $upload->save(true);
                    */
					Yii::app( )->user->setState( 'upload', $userImages );
	 
					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
                            "path" => $path,
							//"url" => $publicPath.$filename,
							//"thumbnail_url" => $publicPath."thumbs/$filename",
							//"delete_url" => $this->createUrl( "upload", array(
							//	"_method" => "delete",
							//	"file" => $filename
							//) ),
							//"delete_type" => "POST"
						) ) );
				} else {
					//clear upload state
                    
                    //If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array( 
						array( "error" => $model->getErrors( 'file' ),
					) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
						CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" 
					);
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
        
	}
    /*
     * Staged uploaded file based on record stored in MarcUpload for later processing
     * 
     * 
     * 
     */
    public function actionStagedUploaded($model)
    {
        
                
        $marcFile = new File_MARC($model->full_path);
        
        $recCount=0;
        $transaction =  Yii::app()->db->beginTransaction();
        
        try
        {
            while ($record = $marcFile->next()) 
            {
                $recCount++;
                $uploadItem = new MarcUploadItem();
                $uploadItem->marc_upload_id = $model->id;
                $uploadItem->marc_xml = $record->toXML();
                $marcInfo = MarcActiveRecord::setMarc($record);
                //build our header
                switch ($model->matching_rule)
                {
                    case MarcUpload::MATCHING_RULE_ISBN:
                        $ident = $marcInfo->getISBN();
                        break;
                    case MarcUpload::MATCHING_RULE_ISSN:
                        $ident = $marcInfo->getISSN();
                        break;
                    default:
                        $ident ='';
                    
                }
                switch ($model->upload_type)
                {
                    case MarcUpload::MARC_UPLOAD_BIBLIO:
                        $title = $marcInfo->getTitle();
                        break;
                    case MarcUpload::MARC_UPLOAD_AUTH:
                        $title = $marcInfo->getAuthor();
                        break;
                    default:
                        $title='';
                    
                }
                $header = ($ident=='' ? '' : $ident . ' / ') . $title ;
                $uploadItem->note = $header;
                $uploadItem->save();
            }
            $model->record_count = $recCount;
            $model->save();
            $transaction->commit();
        }catch (CException $e)
        {
            $transaction->rollback();
        
        }
        
    }
    /**
     * Render the view for individual marc uploaded record
     * 
     * @param integer the ID of the marc record in MarcUploadItem
     */ 
    public function actionViewMarc($id)
    {
        $model = MarcUploadItem::model()->findByPk($id);
        $marc = new File_MARCXML($model->marc_xml, File_MARC::SOURCE_STRING);
        echo $this->renderPartial('_viewmarc',array('marc'=>$marc),true);
             
        
        
    }
    /**
     * Perform marc import based on uploaded file
     * 
     * expect the id of the MarcUpload will be submitted via post
     */ 
    public function actionImport()
    {
        if (!isset($_POST['MarcUpload']))
            throw new CHttpException(400,'Invalid request');
        $id = $_POST['MarcUpload']['id'];
        $upload = MarcUpload::model()->findByPk($id);
        
        $batchImport = new MarcImport($upload);
        $result = $batchImport->import();
        
        echo CJSON::encode(array(
                'status'=>'success', 
                'div'=>$this->renderPartial('_importsummary',array('result'=>$result),true))
                
                
        );
        
        
        
    }
    
    /**
     * Render upload summary which are not already imported to the catalog
     * 
     * 
     * 
     */ 
    public function actionBatchUploadSummary()
    {
        $criteria = new CDbCriteria();
		$criteria->select = 'id,file_name,date_created,record_count,uploaded_by';
        $criteria->condition = 'process_date is null';
        $criteria->with = array('uploadedBy');
		
		$itemDP=new CActiveDataProvider(
			'MarcUpload',
			array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => '20',
				)
			)
		);
        
        $this->render('batchuploadsummary',array('itemDP'=>$itemDP));
        
        
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

}
