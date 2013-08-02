<?php

/**
 * This is the base model class for table "catalog_item".
 *
 * The followings are the available columns in table 'catalog_item':
 * @property integer $id
 * @property integer $catalog_id
 * @property integer $catalog_info_id
 * @property string $barcode
 * @property integer $owner_library
 * @property string $date_acquired
 * @property string $price
 * @property string $replacement_price
 * @property string $call_number
 * @property boolean $reserved
 * @property string $date_last_checked_out
 * @property string $date_last_seen
 * @property integer $checkout_count
 * @property integer $renewal_count
 * @property string $date_last_checked_in
 * @property string $accession_number
 * @property string $control_number
 * @property integer $damage_status
 * @property integer $withdrawn_status
 * @property integer $location_id
 * @property integer $condition_id
 * @property integer $claim_count
 * @property integer $category_id
 * @property integer $smd_id
 * @property integer $lost_status
 * @property integer $not_for_loan_status
 * @property string $check_out_date
 *
 * The followings are the available model relations:
 * @property Catalog $catalog
 * @property Library $ownerLibrary
 * @property CatalogItemInfo $catalogInfo
 *
 * @package application.models.base
 * @name BaseCatalogItem
 */
abstract class BaseCatalogItem extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('catalog_id, catalog_info_id, owner_library, checkout_count, renewal_count, damage_status, withdrawn_status, location_id, condition_id, claim_count, category_id, smd_id, lost_status, not_for_loan_status', 'numerical', 'integerOnly'=>true),
			array('barcode', 'length', 'max'=>25),
			array('control_number,owner_library,location_id,smd_id,category_id', 'required'),
            array('price,local_price, replacement_price', 'length', 'max'=>12),
            array('price,local_price,replacement_price', 'type', 'type'=>'float'),
            array('price,local_price,replacement_price','default','setOnEmpty'=>true,'value'=>0),
			array('call_number', 'length', 'max'=>255),
			array('accession_number, control_number', 'length', 'max'=>30),
            array('date_last_seen','default',
              'value'=>LmUtil::dBCurrentDateTime(),
              'setOnEmpty'=>false,'on'=>'insert'),
			array('date_acquired, currency_id,reserved, date_last_checked_out, check_out_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, catalog_id, catalog_info_id, barcode, owner_library, date_acquired, price, replacement_price, 
			call_number, reserved, date_last_checked_out, date_last_seen, checkout_count, renewal_count, 
			date_last_checked_in, accession_number, control_number, damage_status, withdrawn_status, 
			location_id, condition_id, claim_count, category_id, smd_id, lost_status, invoice_number,
			not_for_loan_status, check_out_date,vendor_id', 'safe', 'on'=>'search'),
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
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'control_number'),
			'ownerLibrary' => array(self::BELONGS_TO, 'Library', 'owner_library'),
			'catalogInfo' => array(self::BELONGS_TO, 'CatalogItemInfo', 'catalog_info_id'),
			'category' =>array(self::BELONGS_TO,'Lookup','category_id','condition'=>'category.category='. "'". Lookup::ITEM_CATEGORY.
            "'"),
            'location' =>array(self::BELONGS_TO,'Location','location_id','condition'=>'location.library_id=t.owner_library'),
            'smd' =>array(self::BELONGS_TO,'Lookup','smd_id','condition'=>'smd.category='. "'". Lookup::ITEM_SMD.
            "'"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'catalog_id' => 'Catalog',
			'catalog_info_id' => 'Catalog Info',
			'barcode' => 'Barcode',
			'owner_library' => 'Owner Library',
			'date_acquired' => 'Date Acquired',
			'price' => 'Price',
			'replacement_price' => 'Replacement Price',
			'call_number' => 'Call Number',
			'reserved' => 'Reserved',
			'date_last_checked_out' => 'Date Last Checked Out',
			'date_last_seen' => 'Date Last Seen',
			'checkout_count' => 'Checkout Count',
			'renewal_count' => 'Renewal Count',
			'date_last_checked_in' => 'Date Last Checked In',
			'accession_number' => 'Accession Number',
			'control_number' => 'Control Number',
			'damage_status' => 'Damage Status',
			'withdrawn_status' => 'Withdrawn Status',
			'location_id' => 'Location',
			'condition_id' => 'Condition',
			'claim_count' => 'Claim Count',
			'category_id' => 'Category',
			'smd_id' => 'Smd',
			'lost_status' => 'Lost Status',
			'not_for_loan_status' => 'Not For Loan Status',
			'check_out_date' => 'Check Out Date',
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
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('catalog_info_id',$this->catalog_info_id);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('owner_library',$this->owner_library);
		$criteria->compare('date_acquired',$this->date_acquired,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('replacement_price',$this->replacement_price,true);
		$criteria->compare('call_number',$this->call_number,true);
		$criteria->compare('reserved',$this->reserved);
		$criteria->compare('date_last_checked_out',$this->date_last_checked_out,true);
		$criteria->compare('date_last_seen',$this->date_last_seen,true);
		$criteria->compare('checkout_count',$this->checkout_count);
		$criteria->compare('renewal_count',$this->renewal_count);
		$criteria->compare('date_last_checked_in',$this->date_last_checked_in,true);
		$criteria->compare('accession_number',$this->accession_number,true);
		$criteria->compare('control_number',$this->control_number,true);
		$criteria->compare('damage_status',$this->damage_status);
		$criteria->compare('withdrawn_status',$this->withdrawn_status);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('condition_id',$this->condition_id);
		$criteria->compare('claim_count',$this->claim_count);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('smd_id',$this->smd_id);
		$criteria->compare('lost_status',$this->lost_status);
		$criteria->compare('not_for_loan_status',$this->not_for_loan_status);
		$criteria->compare('check_out_date',$this->check_out_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
