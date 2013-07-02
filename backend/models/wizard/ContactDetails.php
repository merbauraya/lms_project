<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
Yii::import('bootstrap.widgets.*'); 
class ContactDetails extends CFormModel {
	public $street_address;
	public $locality;
	public $region;
	public $postal_code;
	public $country;

	public function rules() {
		return array(
			array('street_address,locality,region,postal_code,country', 'required')
		);
	}

	public function attributeLabels() {
		return array(
			'locality'=>'Town/City',
			'region'=>'County/State/Province'
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
				'street_address'=>array(),
				'locality'=>array(),
				'region'=>array(),
				'postal_code'=>array(),
				'country'=>array()
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
				'save_draft'=>array(
					'type'=>'submit',
					'label'=>'Save'
				)
			)
		), $this);
	}
}