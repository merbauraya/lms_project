<?php

/**
 * This is the model class for table "budget_account".
 *
 * @package application.models
 * @name BudgetAccount
 *
 */
class BudgetAccount extends BaseBudgetAccount
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BudgetAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
    /**
     * Return list of budget suitable for dropdownlist 
     * 
     * @param allOption whether to add All/NA option to the list
     * 
     */
     public static function getDropDownList($allOption=false,$allText='N/A')
    {
        $models = self::model()->findAll('library_id=:library and is_active=true',array(':library'=>LmUtil::UserLibraryId()));
        $data = array();
        
        if ($allOption)
            $data[null]=$allText;
			//echo CHtml::tag('option',
				//array('value'=>null),CHtml::encode('All'),true);
		foreach($models as $model)
		{
			$data[$model->id]=$model->name;
            //echo CHtml::tag('option',
			//array('value'=>$model->id),CHtml::encode($model->name),true);
		}
        
       return $data;
    }
}
