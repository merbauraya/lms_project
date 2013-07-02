<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
Yii::import('bootstrap.widgets.*'); 
class UserProfile extends CFormModel {
	public $title;
	public $given_name;
	public $family_name;
	public $nickname;
	public $date_of_birth;

	public function rules() {
		return array(
			array('title,given_name,family_name,nickname,date_of_birth', 'required')
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
				'title'=>array(
					'hint'=>'Mr, Ms, Dr, etc.'
				),
				'given_name'=>array(),
				'family_name'=>array(),
				'nickname'=>array(),
				'date_of_birth'=>array()
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
