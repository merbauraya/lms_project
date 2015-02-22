<?php

/**
 * This is the base model class for table "cir_transaction".
 *
 * The followings are the available columns in table 'cir_transaction':
 * @property integer $id
 * @property integer $library_id
 * @property string $patron_username
 * @property string $accession_number
 * @property string $checkout_date
 * @property string $due_date
 * @property string $checkin_date
 * @property string $last_renewed_date
 *
 * The followings are the available model relations:
 * @property CatalogItem $accessionNumber
 * @property Library $library
 * @property Patron $patronUsername
 *
 * @package application.models.base
 * @name BaseCirculationTrans
 */
abstract class BaseCirculationTrans extends LmActiveRecord
{
	private $locationId = null;	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cir_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id,locationId', 'numerical', 'integerOnly'=>true),
			array('accession_number', 'length', 'max'=>20),
			array('library_id,accession_number,member_card_number,patron_username','required'),
         array('member_card_number','exist','allowEmpty' => false, 'attributeName' => 'card_number', 'className' => 'Patron','message'=>'Patron does not exist'),
         array('accession_number','exist','allowEmpty' => false, 'attributeName' => 'accession_number', 'className' => 'CatalogItem','message'=>'Invalid accession number'),
            
		
			array('patron_username, accession_number,checkout_date, due_date, checkin_date, last_renewed_date,locationId', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, library_id, patron_username, accession_number, checkout_date, due_date, checkin_date, last_renewed_date,locationId', 'safe', 'on'=>'search'),
			array('id, library_id, patron_username, accession_number, checkout_date, due_date, checkin_date, last_renewed_date,locationId', 'safe', 'on'=>'overdue'),		
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
			'accession' => array(self::BELONGS_TO, 'CatalogItem', 'accession_number'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'patronUsername' => array(self::BELONGS_TO, 'Patron', 'patron_username'),
			'patronCardNumber' => array(self::BELONGS_TO,'Patron','member_card_number'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'library_id' => 'Library',
			'patron_username' => 'Patron Username',
			'accession_number' => 'Accession Number',
			'checkout_date' => 'Checkout Date',
			'due_date' => 'Due Date',
			'checkin_date' => 'Checkin Date',
			'last_renewed_date' => 'Last Renewed Date',
			'member_card_number' => 'Member Card Number',
			'locationId' => 'Location'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($overdue = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('patron_username',$this->patron_username,true);
		$criteria->compare('accession_number',$this->accession_number,true);
		$criteria->compare('checkout_date',$this->checkout_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('checkin_date',$this->checkin_date,true);
		$criteria->compare('last_renewed_date',$this->last_renewed_date,true);
	   $criteria->compare('member_card_number',$this->member_card_number,true);
	   $criteria->compare('locationid',$this->locationid);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getLocationId()
	{
		if ($this->locationId === null && $this->accession !== null)
		{
			$this->locationId = $this->accession->location_id; 
		}
		return $this->locationId;
		
	}
	public function setLocationId($value)
	{
		$this->locationId = $value;
	}
}
