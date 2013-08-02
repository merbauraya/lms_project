<?php

/**
 * This is the model class for table "budget_transaction".
 *
 * @package application.models
 * @name BudgetTransaction
 *
 */
class BudgetTransaction extends BaseBudgetTransaction
{
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return BudgetTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}