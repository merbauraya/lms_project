<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
Yii::import('bootstrap.widgets.*'); 
class User extends CFormModel {
	public $username;
	public $password;
	public $password_repeat;
	public $email;

	public function rules() {
		return array(
			array('username,password,password_repeat,email', 'required'),
			array('username', 'match', 'pattern'=>'/^\w{6,12}$/'),
			array('password', 'match', 'pattern'=>'/^(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[0-9])[-_a-zA-Z0-9]{8,12}$/'),
			array('password', 'compare', 'message'=>'Passwords do not match'),
			array('email', 'email')
		);
	}

	public function getForm() {
		
		return new TbForm (array(
			'showErrorSummary'=>true,
			'activeForm'=>array(
				'class'=>'bootstrap.widgets.TbActiveForm',
				'type'=>'horizontal',
				'id'=>'good-receive-item-form',
			), 
			'elements'=>array(
				'username'=>array(
					//'hint'=>'6-12 characters; letters, numbers, and underscore'
				),
				'password'=>array(
					'type'=>'password',
					//'hint'=>'8-12 characters; letters, numbers, and underscore; mixed case and at least 1 digit',
				),
				'password_repeat'=>array(
					'type'=>'password',
					//'hint'=>'Re-type your password',
				),
				'email'=>array(
					//'hint'=>'Your e-mail address'
				)
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

	/**
	 * Recovers a partially completed registration.
	 * @param string User registration UUID; data will be recovered from the registration file.
	 * @return mixed array: user registration data; boolean: false if the registration data could not be recovered
	 */
	public function recoverRegistration($uuid) {
		$registrationFile = Yii::getPathOfAlias('application.runtime.registration').DIRECTORY_SEPARATOR.$uuid.'_draft.txt';
		if (file_exists($registrationFile)) {
			$data = unserialize(@file_get_contents($registrationFile));
			unlink($registrationFile);
			return $data;
		}
		else
			return false;
	}

	/**
	 * Saves a draft of registration data.
	 */
	public function saveRegistration($data) {
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);

		$registrationDir = Yii::getPathOfAlias('application.runtime.registration');
		$registrationDirReady = true;
		if (!file_exists($registrationDir)) {
			if (!mkdir($registrationDir) || !chmod($registrationDir, 0775))
				$registrationDirReady = false;
		}
		if ($registrationDirReady && file_put_contents(
			$registrationDir.DIRECTORY_SEPARATOR.$uuid.'_draft.txt', serialize($data)
		))
			return $uuid;
		return false;
	}
}
