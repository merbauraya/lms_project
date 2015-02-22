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
            $model->date_created = LmUtil::CurrentDate();
            if ($model->validate())
            {
                //$model->password = Yii::app()->controller->module->encrypt($model->password);
                if ($model->save())
                    $this->redirect(array('view','id'=>$model->id));
                
            }    
        }
        $this->render('create',array('model'=>$model));
        
    }
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Patron']))
		{
			$model->attributes=$_POST['Patron'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
        
        
    }
    public function actionAdmin()
    {
        
        $model=new Patron('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Patron']))
			$model->attributes=$_GET['Patron'];

		$this->render('admin',array(
			'model'=>$model,
		));
        
    }
    
    /**
	 * Displays a particular model.
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
			'userId'=>$id
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
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Patron::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
