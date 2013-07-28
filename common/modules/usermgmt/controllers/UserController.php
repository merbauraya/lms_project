<?php

class UserController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
    /**
     * 
     * Create new user. If successfull, user will be redirected to view page
     * 
     * 
     */ 
    public function actionCreate()
    {
        $model = new Patron();
        $this->performAjaxValidation($model);
        if (isset($_POST['Patron']))
        {
            $model->attributes = $_POST['Patron'];
            if ($model->validate())
            {
                //$model->password = Yii::app()->controller->module->encrypt($model->password);
                if ($model->save())
                    $this->redirect(array('view','id'=>$model->id));
                
            }    
        }
        $this->render('create',array('model'=>$model));
        
    }
    /**
	 * Displays a particular model.
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='patron-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
    }

}
