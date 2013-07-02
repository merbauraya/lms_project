<?php

/**
 * This is the model class for table "copy_cataloging_resource".
 *
 * @package application.models
 * @name CopyCatalogingResource
 *
 */
class CopyCatalogingResource extends BaseCopyCatalogingResource
{
	
	const TYPE_Z3950_SRUW = 1;
	const TYPE_Z3950_SERVICE = 2;
	const TYPE_OAI_PMH = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CopyCatalogingResource the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getSruServer()
	{
		$model = self::model()->findAll('source_type = :type',
						array(':type'=>self::TYPE_Z3950_SRUW));
							

	}	
}