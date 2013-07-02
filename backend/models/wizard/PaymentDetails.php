<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
Yii::import('bootstrap.widgets.*'); 
class PaymentDetails extends CFormModel {
	public $card_type;
	public $card_number;
	public $card_name;

	public function rules() {
		return array(
			array('card_type,card_number,card_name', 'required')
		);
	}

	public function attributeLabels() {
		return array(
			'card_name'=>'Name on the Card',
		);
	}

	public function getForm() {
		return new TbForm(array(
			'showErrorSummary'=>true,
		'activeForm'=>array(
		'class'=>'bootstrap.widgets.TbActiveForm',
		'type'=>'horizontal',
		'id'=>'good-receive-item-form',
		),
			'elements'=>array(
				'card_type'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						'--- Select ---',
						'American Express'=>'American Express',
						'Diners Club'=>'Diners Club',
						'Discover'=>'Discover',
						'Electron'=>'Electron',
						'Maestro'=>'Maestro',
						'Mastercard'=>'Mastercard',
						'Solo'=>'Solo',
						'Switch'=>'Switch',
						'Visa'=>'Visa'
					)
				),
				'card_number'=>array(),
				'card_name'=>array(),
			),
			'buttons'=>array(
				'previous'=>array(
					'type'=>'submit',
					'label'=>'Previous'
				),
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Register'
				)
			)
		), $this);
	}
}