<?php

/**
 * This is the base model class for table "patron_status".
 *
 * The followings are the available columns in table 'patron_status':
 * @property integer $id
 * @property string $name
 * @property boolean $allow_checkout
 * @property boolean $allow_checkin
 * @property boolean $allow_reserve
 * @property boolean $allow_backend_login
 * @property boolean $allow_opac_login
 * @property boolean $allow_renew
 * @property boolean $allow_comment
 *
 * The followings are the available model relations:
 * @property Patron[] $patrons
 *
 * @package application.models.base
 * @name BasePatronStatus
 */
abstract class BasePatronStatus extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'patron_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>80),
			array('allow_checkout, allow_checkin, allow_reserve, allow_backend_login, allow_opac_login, allow_renew, allow_comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, allow_checkout, allow_checkin, allow_reserve, allow_backend_login, allow_opac_login, allow_renew, allow_comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'patrons' => array(self::HAS_MANY, 'Patron', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'allow_checkout' => 'Allow Checkout',
			'allow_checkin' => 'Allow Checkin',
			'allow_reserve' => 'Allow Reserve',
			'allow_backend_login' => 'Allow Backend Login',
			'allow_opac_login' => 'Allow Opac Login',
			'allow_renew' => 'Allow Renew',
			'allow_comment' => 'Allow Comment',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('allow_checkout',$this->allow_checkout);
		$criteria->compare('allow_checkin',$this->allow_checkin);
		$criteria->compare('allow_reserve',$this->allow_reserve);
		$criteria->compare('allow_backend_login',$this->allow_backend_login);
		$criteria->compare('allow_opac_login',$this->allow_opac_login);
		$criteria->compare('allow_renew',$this->allow_renew);
		$criteria->compare('allow_comment',$this->allow_comment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}