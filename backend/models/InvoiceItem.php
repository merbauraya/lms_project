<?php

/**
 * This is the model class for table "acq_invoice_item".
 *
 * The followings are the available columns in table 'acq_invoice_item':
 * @property integer $id
 * @property integer $acq_invoice_id
 * @property integer $item_no
 * @property string $isbn
 * @property string $isbn_13
 * @property string $call_no
 * @property string $title
 * @property string $quantity
 * @property string $price
 * @property string $local_price
 *
 * The followings are the available model relations:
 * @property AcqInvoice $acqInvoice
 */
class InvoiceItem extends LmActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoiceItem the static model class
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
		return 'acq_invoice_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acq_invoice_id, item_no', 'numerical', 'integerOnly'=>true),
			array('isbn, isbn_13, call_no', 'length', 'max'=>20),
			array('title', 'length', 'max'=>100),
			array('quantity', 'length', 'max'=>5),
			array('price, local_price', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acq_invoice_id, item_no, isbn, isbn_13, call_no, title, quantity, price, local_price', 'safe', 'on'=>'search'),
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
			'acqInvoice' => array(self::BELONGS_TO, 'AcqInvoice', 'acq_invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'acq_invoice_id' => 'Acq Invoice',
			'item_no' => 'Item No',
			'isbn' => 'Isbn',
			'isbn_13' => 'Isbn 13',
			'call_no' => 'Call No',
			'title' => 'Title',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'local_price' => 'Local Price',
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
		$criteria->compare('acq_invoice_id',$this->acq_invoice_id);
		$criteria->compare('item_no',$this->item_no);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('isbn_13',$this->isbn_13,true);
		$criteria->compare('call_no',$this->call_no,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('local_price',$this->local_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}