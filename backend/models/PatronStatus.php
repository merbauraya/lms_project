<?php

/**
 * This is the model class for table "patron_status".
 *
 * @package application.models
 * @name PatronStatus
 *
 */
class PatronStatus extends BasePatronStatus
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PatronStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public static function item($id)
    {
        $model=PatronStatus::model()->findByPk($id);
        if ($model)
            return $model->name;
    }
    public static function items()
    {
        $_items=array();
        $models=PatronStatus::model()->findAll();
        
        foreach($models as $model)
		{
            //self::$_items[$category][$model->id]=$model->name;
			$_items[$model->id]=$model->name;
		}
        return $_items;
        
    }
    private function loadModel($id)
	{
		$model=CatalogItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
}
