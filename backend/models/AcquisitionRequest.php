<?php

/**
 * This is the model class for table "acq_request".
 *
 * @package application.models
 * @name AcquisitionRequest
 *
 */
class AcquisitionRequest extends BaseAcquisitionRequest
{
	//const
	const REQUEST_NEW = 1; //new request
	const REQUEST_ACTIONED = 2; //request has been actioned (rejected or approved)
	
    public $PublicationType;
    /**
	 * Returns the static model of the specified AR class.
	 * @return AcquisitionRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		$criteria->compare('requested_by',$this->requested_by);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('status_id',$this->status_id);
		
		//$criteria->compare('vendor_id',$this->vendor_id);
		
		$criteria->compare('budget_id',$this->budget_id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('request_mode_id',$this->request_mode_id);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('approved_date',$this->approved_date,true);
		$criteria->compare('rejected_by',$this->rejected_by);
		$criteria->compare('rejected_reason',$this->rejected_reason,true);
		$criteria->compare('rejected_date',$this->rejected_date,true);
		$criteria->compare('expected_purchase_date',$this->expected_purchase_date,true);
		$criteria->with = array('requestedBy','budget');
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
