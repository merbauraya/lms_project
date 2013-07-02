<?php

/**
 * This is the model class for table "location".
 *
 * @package application.models
 * @name Location
 *
 */
class Location extends BaseLocation
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getByLibrary($libraryId)
	{
		return self::model()->findAllByAttributes(array(),
			$condition  = 'library_id = :library',
			$params     = array(
			':library' => $libraryId, 
		
			)
		);
	}
}