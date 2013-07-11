<?php

/**
 * This is the model class for table "authority".
 *
 * @package application.models
 * @name Authority
 *
 */
class Authority extends BaseAuthority
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Authority the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}