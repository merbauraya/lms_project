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
			


    }

}