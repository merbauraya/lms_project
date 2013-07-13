<?php

class AuthorityController extends Controller
{
	public $layout='//layouts/column2';
    public function actionIndex()
	{
		$this->render('index');
	}
    public function filters()
	{
		return array(
			array('auth.filters.AuthFilter - login, logout, restore, captcha, error')
            
		);
	}
    public function actionCreate()
    {
        
        $this->render('create');
    }
    /**
     * Render authority marc template based on selected authority type
     * 
     */
     
    public function actionRendertemplate()
    {
        $templateID = $_POST['authType'];
        $authTemplate = AuthorityTag::model()->findAll(array('select'=>'*',
                'condition'=>'authority_type_id=:id',
                'params'=>array(':id'=>$templateID),
                'order'=>'tag')); 
        if (Yii::app()->request->isAjaxRequest){
                Yii::app()->clientScript->scriptMap['*.js'] = false;
        }                
        $this->renderPartial('_auth_tag',array('templates'=>$authTemplate),false,true);
        
    }
    /**
     * Display list of defined authority tag
     * 
     */ 
    public function actionAuthoritytype()
    {
        $model = AuthorityType::model()->findAll();
        $this->render('template',array('model'=>$model));
        
        
    }
    public function actionDeletetag()
    {
        if(Yii::app()->request->isPostRequest && isset($_POST['tag']))
        {
            $typeId = $_POST['authType'];
            $tag = $_POST['tag'];
            $sql = 'delete from authority_subfield where authority_type_id=:id and tag=:tag';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindParam(':id',$typeId,PDO::PARAM_INT);
            $cmd->bindParam(':tag',$tag,PDO::PARAM_STR);
            
            $sql2 = 'delete from authority_tag where authority_type_id=:id and tag=:tag';
            $cmd2 = Yii::app()->db->createCommand($sql2);
            $cmd2->bindParam(':id',$typeId,PDO::PARAM_INT);
            $cmd2->bindParam(':tag',$tag,PDO::PARAM_STR);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $cmd->execute();
                $cmd2->execute();
                $transaction->commit();
                echo 'success';
            }catch (Exception $ex)
            {
                $transaction->rollback();
                LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
                echo $ex.getMessage();
            }
        }else
        {
            echo 'not set';
        }
				
    }
    /**
     * Render list of subfields for a given authority type and tag
     * This is an ajax method
     * 
     */ 
    public function actionLoadsubfield()
    {
        if (isset($_POST['tag']) & isset($_POST['authType']))
        {
            $tag = $_POST['tag'];
            $authType = $_POST['authType'];
            $counter = $_POST['counter'];
            $model = AuthoritySubfield::model()->findAll(array('select'=>'subfield,loc_description,repeatable,mandatory',
                'condition'=>'authority_type_id=:id and tag=:tag',
                'params'=>array(':id'=>$authType,':tag'=>$tag),
                'order'=>'subfield')); 
            if (Yii::app()->request->isAjaxRequest){
                Yii::app()->clientScript->scriptMap['*.js'] = false;
            }
                
            $this->renderPartial('_auth_subfield',array('subfields'=>$model,'counter'=>$counter,'tag'=>$tag),false,true);
        }
        
    }
    /**
     * Delete a subfield from template
     * based on a given template and tag
     * This is an ajax post request
     */
    public function actionDeletesubfield()
    {
        if ((!Yii::app()->request->isAjaxRequest) or (!Yii::app()->request->isPostRequest))
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            return;
        }
        $tag = $_POST['tag'];
        $authType = $_POST['authType'];
        $subfield = $_POST['subfield'];

        $sql = 'delete from authority_subfield 
                where authority_type_id=:typeId 
                and tag=:tagId 
                and subfield=:subfieldId';
        
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':typeId',$authType,PDO::PARAM_INT);
        $cmd->bindParam(':tagId',$tag,PDO::PARAM_STR);
        $cmd->bindParam(':subfieldId',$subfield,PDO::PARAM_STR);
        try
        {
            $cmd->execute();
            
            echo CJSON::encode(array(
				'status'=>'success', 
				'message'=>'Subfield successfully deleted'
				));
        } catch (Exception $ex)
        {
            echo CJSON::encode(array(
				'status'=>'error', 
				'message'=>'Error while deleting subfield'
				));
            LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
                
        }
        
    }
}
