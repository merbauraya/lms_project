<?php

/**
 * This is the model class for table "acq_purchase_order".
 *
 * @package application.models
 * @name PurchaseOrder
 *
 */
class PurchaseOrder extends BasePurchaseOrder
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
	
	//public vars for property display
	public $vendor_name;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @return PurchaseOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
