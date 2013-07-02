<?php

/**
 * This is the model class for table "acq_good_receive".
 *
 * The followings are the available columns in table 'acq_good_receive':
 * @property integer $id
 * @property integer $library_id
 * @property string $vendor_code
 * @property string $shipment_date
 * @property string $invoice_no
 * @property integer $created_by
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property AcqGoodReceiveItem[] $acqGoodReceiveItems
 * @property Library $library
 * @property Patron $createdBy
 * @property Vendor $vendorCode
 */
class GoodReceive extends LmActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GoodReceive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acq_good_receive';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id, created_by', 'numerical', 'integerOnly'=>true),
			array('vendor_code, invoice_no', 'length', 'max'=>20),
			array('shipment_date, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, library_id, vendor_code, shipment_date, invoice_no, created_by, date_created', 'safe', 'on'=>'search'),
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
			'acqGoodReceiveItems' => array(self::HAS_MANY, 'AcqGoodReceiveItem', 'good_receive_id'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'createdBy' => array(self::BELONGS_TO, 'Patron', 'created_by'),
			'vendorCode' => array(self::BELONGS_TO, 'Vendor', 'vendor_code'),
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
			'vendor_code' => 'Vendor Code',
			'shipment_date' => 'Shipment Date',
			'invoice_no' => 'Invoice No',
			'created_by' => 'Created By',
			'date_created' => 'Date Created',
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
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('vendor_code',$this->vendor_code,true);
		$criteria->compare('shipment_date',$this->shipment_date,true);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}