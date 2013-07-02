<?php

/**
 * This is the model class for table "catalog_item".
 *
 * @package application.models
 * @name CatalogItem
 *
 */
 Yii::import('bootstrap.widgets.TbForm'); 
class CatalogItem extends BaseCatalogItem
{
	public $quantity_to_receive;
	public $quantity_received;
	public $price;
	public $local_price;
	public $budget_id;
	public $good_receive_id;
	public $po_item_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	* Return TbForm model. This is used during receiving wizard	
	*
	*
	*/
	public function getForm() {
		$budgetList = CHtml::listData(BudgetAccount::model()->getByLibrary(Yii::app()->user->libraryId),'id','name');
		return new TbForm(array(
			'showErrorSummary'=>false,
			'activeForm'=>array(
				'class'=>'bootstrap.widgets.TbActiveForm',
				'type'=>'horizontal',
				'id'=>'good-receive-item-form',
			), 
			
			'buttons'=>array(
				'previous'=>array(
					'type'=>'submit',
					'label'=>'Previous'
				),
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Next'
				),
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Save'
				)
			)
		), $this);
	}
		
}