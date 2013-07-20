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
	const PERSONAL_NAME=2;
    const CORPORATE_NAME=3;
    const MEETING_NAME=4;
    const UNIFORM_TITLE=5;
    const CRONOLOGICAL_TERM=6;
    const TOPICAL_TERM=7;
    const GEOGRAPHIC_NAME=8;
    const GENRE_FORM_TERM=9;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @return Authority the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}
