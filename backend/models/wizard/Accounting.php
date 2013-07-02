<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
Yii::import('bootstrap.widgets.*'); 
class Accounting extends CFormModel {
	
	public $quantity_to_receive;
	public $quantity_received;
	public $price;
	public $local_price;
	public $budget_id;
	public $good_receive_id;
	public $po_item_id;
	public function rules() {
		return array(
		array('good_receive_id, po_item_id, quantity_to_receive, quantity_received, budget_id', 'numerical', 'integerOnly'=>true),
		array('price, local_price', 'length', 'max'=>19),
		array('date_created', 'safe'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, good_receive_id, po_item_id, quantity_to_receive, quantity_received, date_created, price, local_price, budget_id', 'safe', 'on'=>'search'),
		);
	}

	public function getForm() {
		$budgetList = CHtml::listData(BudgetAccount::model()->getByLibrary(Yii::app()->user->libraryId),'id','name');
		return new TbForm(array(
			'showErrorSummary'=>true,
			'activeForm'=>array(
				'class'=>'bootstrap.widgets.TbActiveForm',
				'type'=>'horizontal',
				'id'=>'good-receive-item-form',
			), 
			'elements'=>array(
				'quantity_to_receive'=>array(),
					
				'quantity_received'=>array(),
				'price'=>array(),
				'local_price'=>array(),
				'budget_id'=>array(
					'type'=>'dropdownlist',
					'items'=>$budgetList,					
                ),
			),
			'buttons'=>array(
				
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Next'
				),
				'save_draft'=>array(
					'type'=>'submit',
					'label'=>'Save'
				)
			)
		), $this);
	}
}
