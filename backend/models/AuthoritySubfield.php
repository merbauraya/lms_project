<?php

/**
 * This is the model class for table "authority_subfield".
 *
 * @package application.models
 * @name AuthoritySubfield
 *
 */
class AuthoritySubfield extends BaseAuthoritySubfield
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AuthoritySubfield the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	} 
	/**
	 * Returns list of Subfield/tag for a given authority type
	 *
	 */   
	public function getByType($typeId)
	{
	    $model=AuthoritySubfield::model()->findAll(array(
    		'select'=>'*',
    		'condition'=>'authority_type_id=:id',
    		'params'=>array(':id'=>$typeId),'order'=>'tag,subfield',
		));
		if ($model)
			return $model;
		else
		{
			throw new CException("Record not found");
		}
        
	}
}
