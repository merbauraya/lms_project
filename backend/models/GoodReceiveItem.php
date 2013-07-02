<?php

/**
 * This is the model class for table "acq_good_receive_item".
 *
 * @package application.models
 * @name GoodReceiveItem
 *
 */
Yii::import('bootstrap.widgets.TbForm'); 
class GoodReceiveItem extends BaseGoodReceiveItem
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GoodReceiveItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	* Returns TbForm used during wizard
	*
	*/
	public function getForm() {
		//$budgetList = CHtml::listData(BudgetAccount::model()->getByLibrary(Yii::app()->user->libraryId),'id','name');
		return new TbForm(array(
			'showErrorSummary'=>true,
			'activeForm'=>array(
				'class'=>'bootstrap.widgets.TbActiveForm',
				'type'=>'horizontal',
				'id'=>'good-receive-item-form',
			), 
			'buttons'=>array(
				
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Next'
				),
				'save_draft'=>array(
					'type'=>'submit',
					'label'=>'Save'
				)
			)
		), $this);
	}
/*
	 * Return data provide of good receive item based on
	 * good receive ID
	 * @param integer rID the ID of the good receive
	 */ 
	public function getByGoodReceiveID($rID)
	{
		$criteria = new CDbCriteria();
		//$criteria->select ='*, local_price * quantity as total_amount ';
		$criteria->condition = 'good_receive_id = :id';
		//$criteria->addCondition('po_text_id = :po_id2','OR');
		$criteria->params = array(':id'=>$rID);
		$criteria->with = 'orderItem';
		//$criteria->params = array(':po_id2'=>$poId);
		return new CActiveDataProvider($this,array(
		'criteria'=>$criteria
		));
		
	}    
}