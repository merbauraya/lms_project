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
}