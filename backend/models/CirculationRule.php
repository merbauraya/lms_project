<?php

/**
 * This is the model class for table "cir_rule".
 *
 * @package application.models
 * @name CirculationRule
 *
 */
class CirculationRule extends BaseCirculationRule
{
	
    const PERIOD_DAY=1;
    const PERIOD_HOUR=2;
    /**
	 * Returns the static model of the specified AR class.
	 * @return CirculationRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}
