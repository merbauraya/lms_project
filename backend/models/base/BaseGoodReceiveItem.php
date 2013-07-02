<?php

/**
 * This is the base model class for table "acq_good_receive_item".
 *
 * The followings are the available columns in table 'acq_good_receive_item':
 * @property integer $id
 * @property integer $good_receive_id
 * @property integer $po_item_id
 * @property integer $quantity_to_receive
 * @property integer $quantity_received
 * @property string $date_created
 * @property string $price
 * @property string $local_price
 * @property integer $budget_id
 *
 * The followings are the available model relations:
 * @property AcqGoodReceive $goodReceive
 *
 * @package application.models.base
 * @name BaseGoodReceiveItem
 */
abstract class BaseGoodReceiveItem extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acq_good_receive_item';
	}
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('good_receive_id, po_item_id, quantity_to_receive, quantity_received, budget_id', 'numerical', 'integerOnly'=>true),
			array('price, local_price', 'length', 'max'=>19),
			array('date_created', 'safe'),
			array('quantity_received','compare','compareAttribute'=>'quantity_to_receive','operator'=>'<=','allowEmpty'=>false,'message'=>'Must be less or equal quantity to receive'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, good_receive_id, po_item_id, quantity_to_receive, quantity_received, date_created, price, local_price, budget_id', 'safe', 'on'=>'search'),
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
			'goodReceive' => array(self::BELONGS_TO, 'GoodReceive', 'good_receive_id'),
			'orderItem'=>array(self::BELONGS_TO,'PurchaseOrderItem','po_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'good_receive_id' => 'Good Receive',
			'po_item_id' => 'Po Item',
			'quantity_to_receive' => 'Quantity To Receive',
			'quantity_received' => 'Quantity Received',
			'date_created' => 'Date Created',
			'price' => 'Price',
			'local_price' => 'Local Price',
			'budget_id' => 'Budget',
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
		$criteria->compare('good_receive_id',$this->good_receive_id);
		$criteria->compare('po_item_id',$this->po_item_id);
		$criteria->compare('quantity_to_receive',$this->quantity_to_receive);
		$criteria->compare('quantity_received',$this->quantity_received);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('local_price',$this->local_price,true);
		$criteria->compare('budget_id',$this->budget_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}