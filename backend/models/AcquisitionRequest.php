<?php

/**
 * This is the model class for table "acq_request".
 *
 * @package application.models
 * @name AcquisitionRequest
 *
 */
class AcquisitionRequest extends BaseAcquisitionRequest
{
	//const
	const REQUEST_NEW = 1; //new request
	const REQUEST_ACTIONED = 2; //request has been actioned (rejected or approved)
	
    public $PublicationType;
    /**
	 * Returns the static model of the specified AR class.
	 * @return AcquisitionRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}
