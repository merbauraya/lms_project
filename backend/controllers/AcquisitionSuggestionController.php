<?php

class AcquisitionSuggestionController extends Controller
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
				'actions'=>array('updateStatus','create','update','Promote',
                                'Reject','KeepInView','precreate','isbnCheck','DeleteItem',
                                'UpdateItem','CreateItem','uploadmarc'),
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
	public function actionCreate()
	{
		
		$model = new AcquisitionSuggestion;
		
	
		$session = Yii::app()->session;
		//$session['isQuote'] = Invoice::DOC_QUOTATION;
		if (isset($_POST['AcquisitionSuggestion']))
		{
			$model->attributes=$_POST['AcquisitionSuggestion'];
			//$model->suggested_by =  Yii::app()->user->getId(); 
			$items =  new AcquisitionSuggestionItem;
			if($model->save())
				$model->text_id = DocumentIdSetting::formatID($model->library_id,AcquisitionSuggestion::DOCUMENT_TYPE,$model->id);
				$model->save(); //TODO move this numbering to db procedure
				$this->redirect(array('update',
									  'id'=>$model->id				  
									  )
							    ); 
		} else {
			$model = new AcquisitionSuggestion;
			$this->render('precreate',array('model'=>$model));
		}
		
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id='')
	{
		$model=$this->loadModel($id)->with('patron');
		
		$items = new AcquisitionSuggestionItem;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AcquisitionSuggestion']))
		{
			$model->attributes=$_POST['AcquisitionSuggestion'];
			$model->status_id = AcquisitionSuggestion::SUGGESTION_NEW;
			$model->suggested_by = Yii::app()->user->getId(); 
			if (!$model->save())
				Yii::app()->user->setFlash('error', '<strong>Error!</strong> Error saving record');
				
		}
		if (isset($_POST['AcquisitionSuggestionItem']))
		{
			$items = $_POST['AcquisitionSuggestionItem'];
			foreach($items as $i=>$item)
				if (isset($_POST['AcquisitionSuggestionItem'][$i]))
				{
					$acqItem = new AcquisitionSuggestionItem;
					$acqItem->attributes = $_POST['AcquisitionSuggestionItem'][$i];
					$acqItem->status_id = AcquisitionSuggestionItem::ITEM_STATUS_NEW;
					$acqItem->save(false);	
				}
				$this->redirect(array('update','id'=>$model->id)); 
			
		}
		$criteria = new CDbCriteria();
		$criteria->condition = 'acq_suggestion_id= :id';
		$criteria->params = array(':id'=>$id);
		$itemDP=new CActiveDataProvider(
			'AcquisitionSuggestionItem',
			array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => '20',
				)
			)
		);
		
		$this->render('create',array(
			'model'=>$model,'items'=>$items,'itemDP'=>$itemDP,
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
		
		$dataProvider=new CActiveDataProvider('AcquisitionSuggestion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AcquisitionSuggestion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AcquisitionSuggestion']))
			$model->attributes=$_GET['AcquisitionSuggestion'];

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
		$model=AcquisitionSuggestion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	* Update suggestion status to 'Promoted' and create record in acq request
	* @param integer $id
	* 
	*/
	public function actionPromote($id)
	{
		if(isset($_GET['ajax']))
		{
			
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				
			
				$model=$this->loadModel($id);
				$acqRequest = new AcquisitionRequest();
				$acqRequest->attributes = $model->attributes;
				$acqRequest->approved_by = Yii::app()->user->getId();
				$acqRequest->request_date = date('Y/m/d');
				$acqRequest->suggestion_id=$model->id;
				$acqRequest->save();
				$model->status_id = AcquisitionSuggestion::SUGGESTION_PROMOTED;
				$model->save();
				if ($trans)
					$trans->commit();
			} catch (Exception $e)
			{
				if ($trans)
				{
					
				
					$trans->rollback();
					Yii::log(__CLASS__ . '::'. __FUNCTION__ .'() failed');
					return false;
				}
				else
				{
					throw $e;
				}
			}
		}
	}
	public function actionKeepInView($id)
	{
		$model=$this->loadModel($id);
		$model->status_id = AcquisitionSuggestion::SUGGESTION_KIV ;
		$model->save();
	}
	public function actionReject($id)
	{
		if(isset($_GET['ajax']))
		{
			
		
			$model=$this->loadModel($id);
			$model->status_id = AcquisitionSuggestion::SUGGESTION_REJECTED ;
			$model->save();
		}
	}
	/**
	* 
	* @param integer $id
	* @param integer $status
	* 
	*/
	protected function actionUpdateStatus($id,$status)
	{
		$model=$this->loadModel($id);
		$model->status_id = $status;
		$model->save();	
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='acquisition-suggestion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	* Create new vendor pricing aka RFQ
	* 
	*/
	public function actionCreateVendorPricing()
	{
		$model = new AcquisitionSuggestionVendorRFQ  ;
		if(isset($_POST['AcquisitionSuggestionVendorRFQ']))
		{
			$model->attributes=$_POST['AcquisitionSuggestionVendorRFQ'];
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->acquisition_suggestion_id));
		}

		$this->render('create_vendor_rfq',array(
			'model'=>$model,
		));
		
	}
	public function actionIsbnCheck()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$isbn = Yii::app()->request->getParam('isbn');
			$isbn13 = Yii::app()->request->getParam('isbn13');
			if ($isbn == '' && $isbn13 =='')
			{
				echo CJSON::encode(array(
				'error'=>'false',
				'message'=>'ISBN Check failed, please enter isbn number'));
				Yii::app()->end();
			}
			
			else
			{
				$gbook = new GoogleBook();
				
				$gbook->isbn = ($isbn =='' ? $isbn13 : $isbn);
				$gbook->query();
				
				
				//pass json data back
				echo CJSON::encode(array(
					'error'=>'false',
					'status'=>'ok',
					'isbn10'=>$gbook->Isbn10,
					'isbn13'=>$gbook->Isbn13,
					'title'=>$gbook->Title,
					'author'=>$gbook->Author,
					'publisheddate'=>$gbook->PublishedDate,
					'publisher'=>$gbook->Publisher,
                                        'thumbnail'=>$gbook->Thumbnail,
                                        'smallthumbnail'=>$gbook->SmallThumbnail,
                                        ));
				 Yii::app()->end();
			}
			
		}
		
	}

	/**
	* Load all suggestion item according to the supplied suggestion id
	* @param integer $id - acquisition suggestion id
	* 
	*/
	protected function loadSuggestionItems($id)
	{
		return AcquisitionSuggestionItem::model()->loadBySuggestionID($id);
		
	}
	public function actionUpdateItem($id)
	{
        $modelItem=AcquisitionSuggestionItem::model()->findByPk($id);
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['AcquisitionSuggestionItem']))
        {
            $modelItem->attributes=$_POST['AcquisitionSuggestionItem'];
            if($modelItem->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>"Item successfully updated"
                        ));
                    exit;               
                }
                else
                    $this->redirect(array('view','id'=>$modelItem->id));
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form_item_popup', array('model'=>$modelItem), true)));
            exit;               
        }
        else
            $this->render('create',array('model'=>$model,));
          
          
        }
    /**
	* Create new suggestion item
	*
	* @param id integer Request ID
	*/
		
	public function actionCreateItem($id='')
	{
        $modelItem= new AcquisitionSuggestionItem();
        $modelItem->acq_suggestion_id=$id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['AcquisitionSuggestionItem']))
        {
            $modelItem->attributes=$_POST['AcquisitionSuggestionItem'];
            $modelItem->acq_suggestion_id=$id;
            unset($modelItem->id); //let db generate our key
			$modelItem->status_id = AcquisitionSuggestionItem::ITEM_STATUS_NEW;
            if($modelItem->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success',
                        'div'=>"Item successfully created"
                        ));
                    exit;
                }
                else
                    $this->redirect(array('view','id'=>$modelItem->id));
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$this->renderPartial('_form_item_popup', array('model'=>$modelItem), true)));
            exit;
        }
        else
            $this->render('create',array('model'=>$model,));
          
          
    }
    public function actionDeleteItem()
	{
		//todo wrap this in single sql stmt
		if(Yii::app()->request->isPostRequest && isset($_POST[
              'ids']))
              {
                $itemIds = $_POST['ids'];
                $acqItemModel = new AcquisitionSuggestionItem();
                foreach ($itemIds as $itemId)
                {
                        $acqItemModel->deleteByPk($itemId);
                }
              }
              /*
              if (isset($_POST['acq_suggestion_item_c0']))
              {
                 $itemsToDelete = $_POST['acq_suggestion_item_c0'];
                 $acqItemModel = new AcquisitionSuggestionItem();
                 foreach ($itemsToDelete as $itemID)
                 {
                         $acqItemModel->deleteByPk($itemID);

                 }
                 $this->redirect('update');
              } */
                /*
              if(Yii::app()->request->isPostRequest)
		{
	        	// we only allow deletion via POST request
//			$this->loadModel($id)->delete();
                        AcquisitionSuggestionItem::model()->findByPK($itemID)->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//	if(!isset($_GET['ajax']))
		//		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                 */
         }
	public function actionUploadMarc()
	{
		$model = new AcquisitionSuggestionItem;
		echo sizeof($_FILES['marc']);
		echo $_FILES['marc']['name'][0];
		echo $_FILES['marc']['tmp_name'][0];
		if (isset($_FILES))
		{
			/*for ($i=0;$i<=sizeof($_FILES['marc'])-2;$i++)
				echo $_FILES['marc']['name'][$i];*/
			echo 'xxxxx';
			exit;
		}
		
		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$this->renderPartial('_file_upload', array('model'=>$model), true)));
            exit;
        }
	
		
	}
	protected function showTextStatus($data, $row)
	{
		switch ($data->status)
		{
			case AcquisitionSuggestion::SUGGESTION_NEW:
				echo 'New Suggestion';
				break;
			case AcquisitionSuggestion::SUGGESTION_PROMOTED:
				echo 'Promoted to Request';
				break;
			case AcquisitionSuggestion::SUGGESTION_REJECTED:
				echo 'Rejected';
				break;
			case AcquisitionSuggestion::SUGGESTION_KIV:
				echo 'KIV';
				break;
		}
		
	}
}
