<?php

/**
 * This is the model class for table "department".
 *
 * @package application.models
 * @name Department
 *
 */
class Department extends BaseDepartment
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);

	}
    /**
    * Return list of department by library that is suitable
    * for populating dropdown
    */
	public function getByLibrary($libraryId)
	{
		$models = self::model()->findAll('library_id=:library',array(':library'=>$libraryId));	


    }
    public static function getDropDownList($allOption=false)
    {
        $models = self::model()->findAll('library_id=:library ',array(':library'=>LmUtil::UserLibraryId()));
        $data = array();
        
        if ($allOption)
            $data[null]='N/A';
			//echo CHtml::tag('option',
			//	array('value'=>null),CHtml::encode('All'),true);
		foreach($models as $model)
		{
			$data[$model->id]=$model->name;
          //  echo CHtml::tag('option',
		//	array('value'=>$model->id),CHtml::encode($model->name),true);
		}
        return $data;
       
    }

}
