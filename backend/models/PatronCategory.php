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
}