<?php

/**
 * This is the base model class for table "cir_rule".
 *
 * The followings are the available columns in table 'cir_rule':
 * @property integer $id
 * @property integer $library_id
 * @property integer $patron_category_id
 * @property integer $smd_id
 * @property integer $item_category_id
 * @property integer $loan_period
 * @property integer $item_count_limit
 * @property integer $period_type
 * @property string $fine_per_period
 * @property integer $max_renewal_count
 * @property integer $max_reservation_count
 *
 * The followings are the available model relations:
 * @property Library $library
 * @property PatronCategory $patronCategory
 *
 * @package application.models.base
 * @name BaseCirculationRule
 */
abstract class BaseCirculationRule extends LmActiveRecord
{
	public $smd_name;
    public $patron_category_name;
    public $item_category_name;
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cir_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id, patron_category_id, smd_id, item_category_id', 'required'),
			array('library_id, patron_category_id, smd_id, item_category_id, loan_period, item_count_limit, period_type, max_renewal_count, max_reservation_count', 'numerical', 'integerOnly'=>true),
			array('fine_per_period', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, library_id, patron_category_id, smd_id, item_category_id,smd_name,patron_category_name,item_category_name  ', 'safe', 'on'=>'search'),
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
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'patronCategory' => array(self::BELONGS_TO, 'PatronCategory', 'patron_category_id'),
            'smd' => array(self::BELONGS_TO,'Lookup','smd_id','condition'=>'"smd"."category"='. "'". Lookup::ITEM_SMD."'"),
            'itemCategory' => array(self::BELONGS_TO,'Lookup','item_category_id','condition'=>'"itemCategory"."category"='. "'". Lookup::ITEM_CATEGORY."'"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'library_id' => 'Library',
			'patron_category_id' => 'Patron Category',
			'smd_id' => 'Smd',
			'item_category_id' => 'Item Category',
			'loan_period' => 'Loan Period',
			'item_count_limit' => 'Item Count Limit',
			'period_type' => 'Period Type',
			'fine_per_period' => 'Fine Per Period',
			'max_renewal_count' => 'Max Renewal Count',
			'max_reservation_count' => 'Max Reservation Count',
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

		$criteria->compare('id',$this->id);
        $criteria->select = 't.id,t.smd_id,t.item_category_id,t.patron_category_id,smd.name as smd_name,
                            itemCategory.name as item_category_name,patronCategory.name as patron_category_name';
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('patron_category_id',$this->patron_category_id);
		$criteria->compare('smd_id',$this->smd_id);
		$criteria->compare('item_category_id',$this->item_category_id);
        $criteria->compare( 'smd.name', $this->smd_name, true );
        $criteria->compare( 'itemCategory.name', $this->item_category_name, true );
		//$criteria->compare('loan_period',$this->loan_period);
		//$criteria->compare('item_count_limit',$this->item_count_limit);
		//$criteria->compare('period_type',$this->period_type);
		//$criteria->compare('fine_per_period',$this->fine_per_period,true);
		//$criteria->compare('max_renewal_count',$this->max_renewal_count);
		//$criteria->compare('max_reservation_count',$this->max_reservation_count);
        $criteria->join = 'LEFT OUTER JOIN lookup_table  smd on (t.smd_id = smd.id and smd.category=\''.Lookup::ITEM_SMD  .'\') 
                           LEFT OUTER JOIN lookup_table  itemCategory on (t.item_category_id = itemCategory.id and itemCategory.category = \''. Lookup::ITEM_CATEGORY. '\' )
                           LEFT OUTER JOIN patron_category patronCategory on (t.patron_category_id = patronCategory.id)';
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
}
