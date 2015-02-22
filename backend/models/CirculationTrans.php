<?php

/**
 * This is the model class for table "cir_transaction".
 *
 * @package application.models
 * @name CirculationTrans
 *
 */
class CirculationTrans extends BaseCirculationTrans
{
	const PERIOD_DAY=1;
	const PERIOD_HOUR=2;
	
	
		/**
	 * Returns the static model of the specified AR class.
	 * @return CirculationTrans the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	*  Determine the given accession number is actually valid
	*  i.e. accession exist and it is checked out
	*  If not, raise 
	*/
	public function validateCheckoutItem($accession)
	{
		$ret = array();
		$ret['ret']=false; //default to false;
		$ret['title']='&nbsp';
		/*
			check if accession exist in trans table and checkin date is null
			If no row returns, mean accession does not exist 
			otherwise if trans record is null, mean item is not check out
			due to outer join
		
		*/
		$sql = 'select  cat.title_245a,a.accession_number,a.control_number, trans.* 
				from catalog cat,catalog_item a
				left outer JOIN cir_transaction trans ON 
					(a.accession_number = trans.accession_number)
				where a.accession_number = :accession
				and cat.control_number = a.control_number
				and trans.checkin_date is null';
		$cmd = Yii::app()->db->createCommand($sql);
		$result = $cmd->queryRow(true,array('accession'=>$accession));
		
		if ($result == null) 
			$ret['message']= 'Accession does not exist';	
		elseif ($result['patron_username'] == null)
			$ret['message']= 'Item is not checked out';
		else
		{
			$ret['ret']=true;
			$ret['message'] = 'Item Valid for checkin';
			$ret['title'] = $result['title_245a'];
		}
		return $ret;
		
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($overdue  = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		//$overdue = false;
		$criteria=new CDbCriteria;
		$criteria->with = "accession";
		$criteria->compare('id',$this->id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('patron_username',$this->patron_username,true);
		$criteria->compare('t.accession_number',$this->accession_number,true);
		$criteria->compare('checkout_date',$this->checkout_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('last_renewed_date',$this->last_renewed_date,true);
	   $criteria->compare('member_card_number',$this->member_card_number,true);
	   $criteria->compare('accession.location_id',$this->locationId);
		
		if ($overdue)
		{
			$now = new CDbExpression("NOW()");
			$criteria->condition = 'due_date < :dueDate';
			$criteria->params = array(':dueDate'=>$now);		
			echo 	'mazlan:'.$this->accession_number;
		}	   
	   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function overdue()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = "accession";
		$criteria->compare('id',$this->id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('patron_username',$this->patron_username,true);
		$criteria->compare('t.accession_number',$this->accession_number,true);
		$criteria->compare('checkout_date',$this->checkout_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('last_renewed_date',$this->last_renewed_date,true);
	   $criteria->compare('member_card_number',$this->member_card_number,true);
	   $criteria->compare('accession.location_id',$this->locationId);
		$now = new CDbExpression("NOW()");
		$criteria->condition = 'due_date < :dueDate';
		$criteria->params = array(':dueDate'=>$now);	   
	   
	   echo 'mxmx'.$this->accession_number;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}