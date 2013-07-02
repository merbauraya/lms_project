<?php

/**
 * This is the model class for table "budget_account".
 *
 * @package application.models
 * @name BudgetAccount
 *
 */
class BudgetAccount extends BaseBudgetAccount
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BudgetAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}