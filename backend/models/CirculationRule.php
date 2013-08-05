<?php

/**
 * This is the model class for table "cir_rule".
 *
 * @package application.models
 * @name CirculationRule
 *
 */
class CirculationRule extends BaseCirculationRule
{
	
    const PERIOD_DAY=1;
    const PERIOD_HOUR=2;
    
    const HARD_DUE_NA = 0;
    const HARD_DUE_BEFORE_LIBRARY_CLOSE=1;
    const HARD_DUE_AFTER_LIBRARY_OPEN=2;
    
    public $patron_category_name ;
    public $smd_name;
    public $item_category_name;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @return CirculationRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
    
    public static function getHardDue()
    {
        return array(
            self::HARD_DUE_NA=>'N/A',
            self::HARD_DUE_BEFORE_LIBRARY_CLOSE=>'Before library is closed',
            self::HARD_DUE_AFTER_LIBRARY_OPEN=>'After library is re-open',
            
        );
    }
    /**
     * Get Rule for specific patron/accession
     * It will also return default rule as  a fallback
     *       
     */
    public static function getRule($patron,$accession)
    {
        //$patron = Patron::model()->findByAttribute('username',$patron)->with('PatronCategory');
        //we find the default rule and the exact rule based on patron/accession
        $sql = 'select a.*,d.username,b.id as itemcategory,c.id as itemsmd,\'exact\' as ruletype
                from cir_rule a, catalog_item b,catalog_item_smd c,patron d, catalog_item_category e
                where a.library_id=:library
                and c.id = b.smd_id
                and a.smd_id = b.smd_id
                and b.accession_number=:accession
                and d.username=:patron
                and d.patron_category_id = a.patron_category_id
                and e.id = a.item_category_id
                union 
                select a.*,null,null,null,\'default\' as ruleType
                from cir_rule a
                where library_id=:library
                and a.smd_id is null
                and a.patron_category_id is null
                and a.item_category_id is null';
        
        $cmd = LmUtil::createDbCommand($sql);
        $cmd->bindValue(':library',LmUtil::UserLibraryId(),PDO::PARAM_INT);
        $cmd->bindValue(':accession',$accession,PDO::PARAM_STR);
        $cmd->bindValue(':patron',$patron,PDO::PARAM_STR);
        
        return $cmd->queryAll();
        
        
    }
    
    
    public function getAdminView()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 't.*,smd.name as smd_name,
                            itemCategory.name as item_category_name,patronCategory.name as patron_category_name';
	
		$criteria->compare('id',$this->id);
		$criteria->compare('t.library_id',LmUtil::UserLibraryId());
		$criteria->compare('patron_category_id',$this->patron_category_id);
		$criteria->compare('smd_id',$this->smd_id);
		$criteria->compare('item_category_id',$this->item_category_id);
		$criteria->compare('loan_period',$this->loan_period);
        $criteria->join = 'LEFT OUTER JOIN patron_category patronCategory on 
                                (t.patron_category_id = patronCategory.id and t.library_id=patronCategory.library_id)
                           LEFT OUTER JOIN catalog_item_category itemCategory on  
                                (t.item_category_id = itemCategory.id and t.library_id = itemCategory.library_id)
                           LEFT OUTER JOIN catalog_item_smd smd on 
                                (t.smd_id = smd.id and t.library_id=smd.library_id)
                           ';
        //$criteria->addCondition('library_id='.)
        $criteria->together = true;
	

				return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'smd_name'=>array(
                        'asc' => 'smd.name',
                        'desc' => 'smd.name DESC'
                    ),
                    'item_category_name'=>array(
                        'asc' => 'itemCategory.name',
                        'desc' => 'itemCategory.name DESC'
                    ),
                    'patron_category_name'=>array(
                        'asc' => 'patronCategory.name',
                        'desc' => 'patronCategory.name DESC'
                    ), 
                    '*',
                )
            )
		));
        
        
    }
    public static function getDueDate($username,$accession)
    {
        
        
        
    }
   
}
