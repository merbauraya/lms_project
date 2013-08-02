<?php

class CatalogController extends Controller
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
    public function actionNonIndex()
    {
         
        
        
        $criteria = new CDbCriteria();
		$criteria->select = 'id,title_245a,date_created,author_100a,isbn_10,source';
        $criteria->condition = 'indexed = false';
		$itemDP=new CActiveDataProvider(
			'Catalog',
			array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => '20',
				)
			)
		);
        $this->render('viewer',array('dataProvider'=>$itemDP));
        
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
