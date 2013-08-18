<?php

/**
 * This is the model class for table "acq_purchase_order_item".
 *
 * @package application.models
 * @name PurchaseOrderItem
 *
 */
class PurchaseOrderItem extends BasePurchaseOrderItem
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
	 * @return PurchaseOrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		//$criteria->addCondition('po_text_id = :po_id2','OR');
        
		$criteria->params = array(':po_id'=>$poId);//,':po_id2'=>$poId);
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
