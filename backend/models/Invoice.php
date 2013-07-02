<?php

/**
 * This is the model class for table "acq_invoice".
 *
 * The followings are the available columns in table 'acq_invoice':
 * @property integer $id
 * @property integer $library_id
 * @property integer $vendor_id
 * @property integer $po_id
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $date_created
 * @property integer $created_by
 * @property integer $status_id
 * @property string $due_date
 * @property integer $currency_id
 * @property string $invoice_amount
 * @property string $paid_amount
 * @property string $last_paid_date
 *
 * The followings are the available model relations:
 * @property AcqInvoiceItem[] $acqInvoiceItems
 * @property Library $library
 * @property AcqPurchaseOrder $po
 * @property Vendor $vendor
 */
class Invoice extends LmActiveRecord
{
	/* Invoice Statuses  */
	const STATUS_DRAFT=1;
	const STATUS_POSTED=2;
	const STATUS_PARTIALLY_PAID=3;
	const STATUS_CLOSED=4;
	
	const DOCUMENT_TYPE='INVOICE';
	
	/* our invoice status category in lookup table */
	const STATUS_CATEGORY='INVOICE_STATUS';
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoice the static model class
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
		return 'acq_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id, vendor_code, invoice_no,po_text_id, invoice_date,invoice_amount', 'required'),
			array('library_id, created_by, status_id, currency_id', 'numerical', 'integerOnly'=>true),
			array('invoice_no,vendor_code', 'length', 'max'=>20),
			array('invoice_amount, paid_amount', 'length', 'max'=>10),
			array('local_amount,due_date,notes', 'safe'),
			array('po_text_id','length','max'=>20),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, library_id, vendor_code, po_text_id, invoice_no, 
			       invoice_date, date_created, created_by, status_id, due_date, 
				   currency_id, invoice_amount, po_text_id,paid_amount, 
				   last_paid_date', 'safe', 'on'=>'search'),
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
			'InvoiceItems' => array(self::HAS_MANY, 'AcqInvoiceItem', 'acq_invoice_id'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'po' => array(self::BELONGS_TO, 'PurchaseOrder', 'po_text_id'),
			'vendor' => array(self::BELONGS_TO, 'Vendor', 'vendor_code'),
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
			'vendor_code' => 'Vendor',
			'po_text_id' => 'Purchase Order #',
			'invoice_no' => 'Invoice No',
			'invoice_date' => 'Invoice Date',
			'date_created' => 'Date Created',
			'created_by' => 'Created By',
			'status_id' => 'Status',
			'due_date' => 'Due Date',
			'currency_id' => 'Currency',
			'invoice_amount' => 'Invoice Amount',
			'paid_amount' => 'Paid Amount',
			'last_paid_date' => 'Last Paid Date',
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
		$criteria->compare('vendor_code',$this->vendor_code);
		$criteria->compare('po_text_id',$this->po_text_id);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('invoice_amount',$this->invoice_amount,true);
		$criteria->compare('paid_amount',$this->paid_amount,true);
		$criteria->compare('last_paid_date',$this->last_paid_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}