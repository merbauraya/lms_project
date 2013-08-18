<?php

/**
 * This is the model class for table "currency".
 *
 * @package application.models
 * @name Currency
 *
 */
class Currency extends BaseCurrency
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Currency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /**
     * Return list of currency suitable for dropdownlist
     * 
     */
     public static function getDropDownList()
     {
         $models = self::model()->findAll();
         $data = array();
         
         foreach($models as $model)
         {
             $data[$model->region][$model->id] = $model->code .' - '. $model->name;
         }
         return $data;
         
     }    
     /*
      * Return currency exchange rate. If setting exchange rate equal to requested exchange rate, rate will 1
      * @param var mixed. If id is integer, it will read id column, if id is code, it will read code column
      * of currency table
      */
    public static function getExchangeRate($var)
    {
        if (is_int($var))
            $model = self::model()->find('id=:id',array(':id'=>$var));
        else
            $model = self::model()->find('code=:id',array(':id'=>$var));
        if ($model)
            return $model->conversion_rate;
        else
            return null;
        
    }
}
