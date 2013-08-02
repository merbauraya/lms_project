<?php

/**
 * This is the model class for table "acq_purchase_order_item".
 *
 * The followings are the available columns in table 'acq_purchase_order_item':
 * @property integer $id
 * @property string $call_no
 * @property string $isbn
 * @property string $isbn_13
 * @property string $title
 * @property string $author
 * @property integer $currency_id
 * @property string $price
 * @property integer $quantity
 * @property integer $quantity_received
 * @property integer $status_id
 * @property string $date_received
 * @property integer $purchase_order_id
 * @property integer $request_item_id
 * @property integer $budget_id
 *
 * The followings are the available model relations:
 * @property AcqRequestItem $requestItem
 * @property Currency $currency
 * @property AcqPurchaseOrder $purchaseOrder
 * @property BudgetAccount $budget
 */
class PurchaseOrderItem extends LmActiveRecord
{
	//Purchase order Item Status
	const STATUS_NEW = 1 ;
	const STATUS_RELEASED = 2 ; //released means PO has been submitted to vendor
	const STATUS_CANCELLED = 3; //item has been cancelled
	const STATUS_PARTIAL_DELIVERED = 4; //
	const STATUS_REJECTED =5; //item rejected by vendor
	const STATUS_DELIVERY_COMPLETED = 6;
	
	//status flag
	const STATUS_ALL = -1;
	
	public $total_amount;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PurchaseOrderItem the static model class
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
		return 'acq_purchase_order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('currency_id, quantity, quantity_received, status_id, purchase_order_id, request_item_id, budget_id,department_id', 'numerical', 'integerOnly'=>true),
			array('call_no, isbn, isbn_13', 'length', 'max'=>15),
			array('title', 'length', 'max'=>100),
			array('price', 'length', 'max'=>10),
			array('po_text_id', 'length', 'max'=>30),
			array('publisher', 'length', 'max'=>80),
			array('price,local_price', 'type', 'type'=>'float'),
			array('date_received', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, po_text_id,call_no, isbn, isbn_13, title, author, currency_id, price, quantity, quantity_received, status_id, date_received, purchase_order_id, request_item_id,publisher,department_id, budget_id', 'safe', 'on'=>'search'),
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
			'requestItem' => array(self::BELONGS_TO, 'AcqRequestItem', 'request_item_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'purchaseOrder' => array(self::BELONGS_TO, 'PurchaseOrder', 'purchase_order_id'),
			'budget' => array(self::BELONGS_TO, 'BudgetAccount', 'budget_id'),
			'department'=> array(self::BELONGS_TO, 'Department', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'call_no' => 'Call No',
			'isbn' => 'Isbn',
			'isbn_13' => 'Isbn 13',
			'title' => 'Title',
			'author' => 'Author',
			'currency_id' => 'Currency',
			'price' => 'Price',
			'quantity' => 'Quantity',
			'quantity_received' => 'Quantity Received',
			'status_id' => 'Status',
			'date_received' => 'Date Received',
			'purchase_order_id' => 'Purchase Order',
			'request_item_id' => 'Request Item',
			'budget_id' => 'Budget',
			'po_text_id' => 'Purchase Order #',
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

		
		$criteria->compare('call_no',$this->call_no,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('isbn_13',$this->isbn_13,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('quantity_received',$this->quantity_received);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('date_received',$this->date_received);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('request_item_id',$this->request_item_id);
		$criteria->compare('budget_id',$this->budget_id);
		$criteria->compare('po_text_id',$this->po_text_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getReleasedNonClosedItem($poID)
	{
		$status = array(self::STATUS_RELEASED,self::STATUS_PARTIAL_DELIVERED);
		return $this->getByStatus($poID,$status);
		
	}
	public function getItemByPurchaseOrder($poId)
	{
		return $this->getByStatus($poId,array());
	}
	/**
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on 
	 * the search/filter conditions.
	 * @param integer $poId the Purchase Order ID the items belong to
	 * @param array $status the status of the Order item to be retrieved
	 */
	 
	private function getByStatus($poId,$status=array())
	{
		$criteria = new CDbCriteria();
		$criteria->select ='*, local_price * quantity as total_amount ';
		$criteria->condition = 'purchase_order_id = :po_id';
		$criteria->addCondition('po_text_id = :po_id2','OR');
        
		$criteria->params = array(':po_id'=>$poId,':po_id2'=>$poId);
		if (count($status)>0)
        {
			$criteria->addInCondition('status_id',$status);

        }
		//$criteria->params = array(':po_id2'=>$poId);
		return new CActiveDataProvider($this,array(
				'criteria'=>$criteria
			)
		);
	}
}