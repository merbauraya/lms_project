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
}