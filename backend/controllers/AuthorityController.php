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
        $model = new Authority();
        $this->render('create',array('model'=>$model));
    }
    /**
     * Render authority marc template based on selected authority type
     * 
     */
     
    public function actionRendertemplate()
    {
        $templateID = $_POST['authType'];
        $authTemplate = AuthorityTemplateSubfield::model()->findAll(array('select'=>'*',
                'condition'=>'authority_type_id=:id',
                'params'=>array(':id'=>$templateID),
                'order'=>'tag,subfield')); 
        if (Yii::app()->request->isAjaxRequest){
                Yii::app()->clientScript->scriptMap['*.js'] = false;
        }                
        $this->renderPartial('_form',array('templates'=>$authTemplate),false,true);
        
    }
    /**
     * Render list of defined tag for a given authority template
     * 
     */
    public function actionRendertemplatetag()
    {
        $templateID = $_POST['authType'];
        $authTemplate = AuthorityTemplateTag::model()->findAll(array('select'=>'*',
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
    /**
     * Delete tag from authority template
     * This is an ajax post call only
     * 
     */
    public function actionDeletetag()
    {
        if(Yii::app()->request->isPostRequest && isset($_POST['tag']))
        {
            $typeId = $_POST['authType'];
            $tag = $_POST['tag'];
            $sql = 'delete from authority_template_subfield where authority_type_id=:id and tag=:tag';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindParam(':id',$typeId,PDO::PARAM_INT);
            $cmd->bindParam(':tag',$tag,PDO::PARAM_STR);
            
            $sql2 = 'delete from authority_template_tag where authority_type_id=:id and tag=:tag';
            $cmd2 = Yii::app()->db->createCommand($sql2);
            $cmd2->bindParam(':id',$typeId,PDO::PARAM_INT);
            $cmd2->bindParam(':tag',$tag,PDO::PARAM_STR);
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $cmd->execute();
                $cmd2->execute();
                $transaction->commit();
                echo CJSON::encode(array(
                    'status'=>'success', 
                    'message'=>'Tag/subfield successfully added'
                    ));
            }catch (Exception $ex)
            {
                $transaction->rollback();
                LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.$this->action->id);
                echo CJSON::encode(array(
                    'status'=>'error', 
                    'message'=>'Error deleting tag/subfield'
                    ));
                
            }
        }else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            return;
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
            $model = AuthorityTemplateSubfield::model()->findAll(array('select'=>'subfield,loc_description,repeatable,mandatory',
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

        $sql = 'delete from authority_template_subfield 
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
    /**
     * Render list of subfield and tag for a given template tab (tabkey)
     * The tag must be a tabkey. For example 0 will retrieve all tag between 0 and 99
     * 100 will retrieve all tag between 100 and 199
     * This is an ajax and post only method
     * 
     */
    public function actionGettemplatetag()
    {
        //check if we are requesting list of subfield 
        if (isset($_POST['tag']) & isset($_POST['template']))
        {
            $tagKey = $_POST['tag'];
            $template =$_POST['template'];
            //get low and high tag
            
            $lowTag = (int)$tagKey +'00';
            
            $highTag = (int)$tagKey+99;
            if ((int)$tagKey==0)
            {
                $lowTag = '000';
                $highTag='099';
            }
            $tagType='AUTH';
            /*
            $model = MarcTag::model()->with(array('subfields'))->together()->findAll(array(
                'select'=>'t.tag,t.loc_description as tag_name,subfields.subfield,loc_desc as subfield_name',
                'condition'=>'t.tag  >=:lowid and t.tag <= :highid and t.tag_type=:tagType',
                'params'=>array(':lowid'=>$lowTag,':highid'=>$highTag,':tagType'=>'AUTH'),
                'order'=>'t.tag,subfields.subfield'));
            
            $criteria = new CDbCriteria();
            $criteria->condition = 't.tag >= :lowid and t.tag <= :highid and t.tag_type=:auth';
            $criteria->params = array(':lowid'=>$lowTag,':highid'=>$highTag, ':auth'=>'AUTH');
            //$criteria->with = array('customers'=>array('select'=>'name')); <--- I think should be like this
            $criteria->with = array('subfields'=>array('select'=>'subfield'));
            $criteria->together = true;
            $criteria->select = 't.tag,t.loc_description,subfield';
            $model = MarcTag::model()->findAll($criteria);
            */
            
            $sql =  'select a.tag, a.loc_description as tag_name 
                    from marc_tag a
                    where a.tag between :lowid and :highid
                    and a.tag_type= :tagType
                    order by a.tag';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindParam(':lowid',$lowTag,PDO::PARAM_STR);
            $cmd->bindParam(':highid',$highTag,PDO::PARAM_STR);
            $cmd->bindParam(':tagType',$tagType,PDO::PARAM_STR);
            $model = $cmd->queryAll();
            //$list= Yii::app()->db->createCommand('select * from post where category=:category')->bindValue('category',$category)->queryAll();

            
            echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$this->renderPartial('_template_tag_popup', array('model'=>$model), true)));
            
        }
      
    }
    /**
     * Render list of subfield during add subfield popup to the template
     * It will return only subfield which are currently not part of template tag
     * 
     */
    public function actionAddtagloadsubfield()
    {
        if ((!Yii::app()->request->isAjaxRequest) or (!Yii::app()->request->isPostRequest))
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            return;
        }
        $authType = $_POST['authType'];
        $tag = $_POST['tag'];
        $sql = 'SELECT a.tag,a.subfield,a.loc_desc as subfield_name
                FROM marc_subfield a
                LEFT OUTER JOIN (select tag,subfield from authority_template_subfield where authority_type_id=:authType) b
                ON a.tag = b.tag and a.subfield = b.subfield
                where a.tag=:tag
                and a.tag_type=\'AUTH\'
                and b.subfield is null';
        
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindParam(':authType',$authType,PDO::PARAM_INT);
        $cmd->bindParam(':tag',$tag,PDO::PARAM_STR);
        $model = $cmd->queryAll();
        $this->renderPartial('_template_subfield_popup',array('model'=>$model,'tag'=>$tag));
    }
    /**
     * Save tag and subfield to the template
     * 
     */
    public function actionSavesubfield()
    {
        if ((!Yii::app()->request->isAjaxRequest) or (!Yii::app()->request->isPostRequest))
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            return;
        }
        if (!isset($_POST['Marc']) )
            return;
        $atts  = $_POST['Marc'];
        $authType = $_POST['template'];
        $sql=array();
        $tags = array();
        //this is our authority_template_tag insert
        $sql1 = 'INSERT INTO authority_template_tag 
                    (authority_type_id,tag,loc_description,help_text,repeatable,mandatory)
                    select :authType,tag,loc_description,help_text,repeatable,mandatory 
                    from marc_tag
                    where tag=:tag and tag_type=\'AUTH\' 
                    and NOT EXISTS 
                        (SELECT 1 FROM authority_template_tag WHERE authority_type_id=:authType and tag=:tag)';
        //our authority_template_subfield insert
        $sql2 = 'insert into authority_template_subfield
                (authority_type_id,tag,subfield,loc_description,help_text,repeatable,mandatory)
                select :authType,tag,subfield,loc_desc,help_text,repeatable,mandatory 
                from marc_subfield
                where tag=:tag
                and subfield=:subfield
                and tag_type=\'AUTH\'
                and NOT EXISTS 
                (select 1 from authority_template_subfield 
                    where tag=:tag 
                    and subfield=:subfield 
                    and authority_type_id=:authType)'  ;  
        foreach ($atts as $key=>$value)
        {
            //key has the following format
            //130-6-sck, where 130=tag, 6=subfield, sck=just a flag
            $tag = substr($key,0,3);
            $subfield = substr($key,4,1);
            
            //prepare our tag part
            if (!in_array($tag,$tags))
            {
                $cmd = Yii::app()->db->createCommand($sql1);  
                $cmd->bindValue(':authType',$authType,PDO::PARAM_INT);
                $cmd->bindValue(':tag',$tag,PDO::PARAM_STR);
                $sql[] = $cmd;
                $tags[] = $tag; //save current tag
                
            }
            $cmd = Yii::app()->db->createCommand($sql2);  
            $cmd->bindValue(':authType',$authType,PDO::PARAM_INT);
            $cmd->bindValue(':tag',$tag,PDO::PARAM_STR);
            $cmd->bindValue(':subfield',$subfield,PDO::PARAM_STR);
            
            $sql[] = $cmd;
            
            
            //now subfield part
            
            
        } //foreach
        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            foreach ($sql as $cmd)
                $cmd->execute();
            
            $transaction->commit();
            echo CJSON::encode(array(
                    'status'=>'success', 
                    'message'=>'Subfield/tag successfully added'
                    ));
        }catch (Exception $ex)
        {
            $transaction->rollback();
            LmUtil::logError('DB Error : ' .$ex->getMessage(),$this->id.'.'.$this->action->id);
            echo CJSON::encode(array(
                    'status'=>'error', 
                    'message'=>'Error perfoming requested task'
                    ));
        }
        
    }
}
