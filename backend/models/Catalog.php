<?php

/**
 * This is the model class for table "catalog".
 *
 * @package application.models
 * @name Catalog
 *
 */
class Catalog extends BaseCatalog
{
	
    const SOURCE_MARC_IMPORT=1;
	const SOURCE_MANUAL_ENTRY=2;
	const SOURCE_COPY_CATALOG=3;
    /**
	 * Returns the static model of the specified AR class.
	 * @return Catalog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function findByISBN($isbn)
    {
        $model = Catalog::model()->findAll('isbn_10=:isbn or isbn_13=:isbn',array(':isbn'=>$isbn));
        return $model;
        
    }
    public function findByISSN($issn)
    {
        $model = Catalog::model()->findAll('issn=:issn',array(':issn'=>$issn));
        return $model;
    }    
}
