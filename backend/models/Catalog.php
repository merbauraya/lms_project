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
	//Marc record source
    const SOURCE_MARC_IMPORT=1;
	const SOURCE_MANUAL_ENTRY=2;
	const SOURCE_COPY_CATALOG=3;
    
    
    //catalog search type
    const SEARCH_TITLE=1;
    const SEARCH_AUTHOR=2;
    const SEARCH_ISBN=3;
    const SEARCH_ISSN=4;
    const SEARCH_CONTROL_NUMBER =5;
    
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
    /**
     * Return an array for supported search type which is suitable for dropdown list
     * 
     * 
     * 
     */     
    public static function getSearchType()
    {
        return array(   self::SEARCH_TITLE=>'Title',
                        self::SEARCH_AUTHOR=>'Author',
                        self::SEARCH_CONTROL_NUMBER=>'Control Number',
                        self::SEARCH_ISBN=>'ISBN',
                        self::SEARCH_ISSN=>'ISSN');
        
    }
}
