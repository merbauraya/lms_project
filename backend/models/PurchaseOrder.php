<?php

/**
 * This is the model class for table "acq_purchase_order".
 *
 * The followings are the available columns in table 'acq_purchase_order':
 * @property integer $id
 * @property integer $created_by
 * @property string $date_created
 * @property integer $order_mode_id
 * @property integer $source_id
 * @property integer $modified_by
 * @property string $modified_date
 * @property string $manual_ref_no
 * @property integer $vendor_id
 * @property string $po_date
 * @property string $text_id
 * @property string $required_ship_date
 * @property integer $department_id
 * @property integer $budget_id
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property AcqPurchaseOrderItem[] $acqPurchaseOrderItems
 * @property Patron $createdBy
 * @property Patron $modifiedBy
 * @property AcqRequestItem[] $acqRequestItems
 */
class PurchaseOrder extends LmActiveRecord
{
	const STATUS_NEW = 1;
	const STATUS_RELEASED = 2;
	const STATUS_CANCELLED=3;
	const STATUS_PARTIAL_DELIVERED = 4;
	const STATUS_REJECTED = 5;
	const STATUS_COMPLETED=6;
	const STATUS_CATEGORY_CODE='PO_STATUS';
	
	const ORDER_MODE_CATEGORY='PO_ORDER_MODE';
	const ORDER_SOURCE='PO_ORDER_SOURCE';
	
	
	const DOCUMENT_TYPE='PURCHASE_ORDER';
	
	//public vars
	public $vendor_name;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PurchaseOrder the static model class
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
		return 'acq_purchase_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_by, po_date', 'required'),
			array('created_by, order_mode_id, source_id, modified_by, vendor_id, department_id, budget_id, library_id,status_id', 'numerical', 'integerOnly'=>true),
			array('manual_ref_no', 'length', 'max'=>30),
			array('text_id,vendor_code', 'length', 'max'=>20),
			
			array('date_created, modified_date, required_ship_date,notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_by, date_created, order_mode_id, source_id, modified_by, modified_date, manual_ref_no, po_date, text_id, required_ship_date, library_id,department_id, budget_id, status_id,vendor_code,vendor_name', 'safe', 'on'=>'search'),
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
			'PurchaseOrderItems' => array(self::HAS_MANY, 'AcqPurchaseOrderItem', 'purchase_order_id'),
			'createdBy' => array(self::BELONGS_TO, 'Patron', 'created_by'),
			'modifiedBy' => array(self::BELONGS_TO, 'Patron', 'modified_by'),
			'acqRequestItems' => array(self::HAS_MANY, 'AcqRequestItem', 'purchase_order_id'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'budget'=>array(self::BELONGS_TO,'BudgetAccount','budget_id'),
			'vendor'=>array(self::BELONGS_TO,'Vendor','vendor_code')
		);
	}
	public function scopes()
	{
		return array(
			'vendor'=>array(
				'with'=>'vendor',
			),
		'recently'=>array(
			'order'=>'date_created DESC',
			'limit'=>10,
			),
        ); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_by' => 'Created By',
			'date_created' => 'Date Created',
			'order_mode_id' => 'Order Mode',
			'source_id' => 'Source',
			'modified_by' => 'Modified By',
			'modified_date' => 'Modified Date',
			'manual_ref_no' => 'Manual Ref No',
			'vendor_id' => 'Vendor',
			'po_date' => 'Po Date',
			'text_id' => 'PO. Number',
			'required_ship_date' => 'Required Ship Date',
			'department_id' => 'Department',
			'budget_id' => 'Budget',
			'status_id' => 'Status',
			'library_id' =>'Library',
			'vendor_code' =>'Vendor',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($withArray=array(),$aliases=array())
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if ($withArray)
			$criteria->with=$withArray;
		
	
		$criteria->compare('id',$this->id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('order_mode_id',$this->order_mode_id);
		$criteria->compare('source_id',$this->source_id);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('manual_ref_no',$this->manual_ref_no,true);
		if (in_array('vendor',$withArray))
		{
			$criteria->compare( 'vendor.name', $this->vendor_name, true );
		}
		
		$criteria->compare('vendor_code',$this->vendor_code);
		$criteria->compare('po_date',$this->po_date,true);
		$criteria->compare('text_id',$this->text_id,true);
		$criteria->compare('required_ship_date',$this->required_ship_date,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('budget_id',$this->budget_id);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getByStatus($status=self::STATUS_NEW)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('vendor_code',$this->vendor_code);
		$criteria->compare('text_id',$this->text_id,true);
		$criteria->condition=('t.status_id=:status_id');
		$criteria->with=array('budget','createdBy','vendor');
		/*$criteria->select = array('id','date_created','vendor_code',
							'po_date','po_amount','created_by','budget_id',
							'required_ship_date','text_id','name');*/
		
		$criteria->params = array(':status_id'=>$status);
		
		return new CActiveDataProvider ($this, array(
			'criteria'=>$criteria,
		));
	
	
	}
	public function getPoByVendor($vendor,$status=self::STATUS_NEW)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('vendor_code',$vendor);
		$criteria->compare('status_id',$status);
		$criteria->select='id,text_id';
		return $this->findAll($criteria);
		
	}
	
}