<?php

/**
 * This is the model class for table "patron_category".
 *
 * @package application.models
 * @name PatronCategory
 *
 */
class PatronCategory extends BasePatronCategory
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PatronCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /*
     * Return list of Patron Category suitable for dropdown list
     * @param addAll if true, All option will be appended to the list
     * 
     */
    public static function getList($addAllOption = false)    
    {
        
        $models = PatronCategory::model()->findAll(array(
                                            'condition'=>'library_id=:library',
                                            'order'=>'id',
                                            'params'=>array(':library'=>LmUtil::UserLibraryId()))
        );
        
        
        
        $options = CHtml::listData($models,'id','name');
        if ($addAllOption)
            $options =  array_merge(array(0=>'All'),$options);
     
        return $options;
       
    }
}
