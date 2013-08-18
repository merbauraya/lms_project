<?php

/**
 * This is the model class for table "acq_suggestion".
 *
 * @package application.models
 * @name AcquisitionSuggestion
 *
 */
class AcquisitionSuggestion extends BaseAcquisitionSuggestion
{
	
    //suggestion status
	const SUGGESTION_NEW = 1;
    const SUGGESTION_PROMOTED = 2;
    const SUGGESTION_REJECTED = 3;
    const SUGGESTION_APPROVED = 4;
	
	const DOCUMENT_TYPE= 'ACQ_SUGGESTION';
    /**
	 * Returns the static model of the specified AR class.
	 * @return AcquisitionSuggestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getActiveSuggestion($library_id,$budget_id =null)
	{
		$criteria = new CDbCriteria;
		$criteria->select='id,suggest_date,text_id ';
		$criteria->condition='status_id = :suggest_status';
		$criteria->addCondition('library_id= :library_id');
		if (!is_null($budget_id))
        {
            $criteria->addCondition('budget_id= :budget_id');
            $criteria->params[':budget_id']= $budget_id;
        }
        $criteria->params[':suggest_status'] = self::SUGGESTION_NEW;
		$criteria->params[':library_id']= $library_id;
		
		return AcquisitionSuggestion::model()->findAll($criteria);
	}    
}
