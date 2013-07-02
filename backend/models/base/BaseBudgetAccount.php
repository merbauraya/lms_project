<?php

/**
 * This is the base model class for table "budget_account".
 *
 * The followings are the available columns in table 'budget_account':
 * @property integer $id
 * @property string $budget_code
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property string $date_created
 * @property integer $created_by
 * @property integer $library_id
 * @property integer $dept_id
 * @property boolean $is_active
 *
 * The followings are the available model relations:
 * @property Department $dept
 * @property Library $library
 * @property AcqPurchaseOrderItem[] $acqPurchaseOrderItems
 *
 * @package application.models.base
 * @name BaseBudgetAccount
 */
abstract class BaseBudgetAccount extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budget_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('budget_code, library_id', 'required'),
			array('created_by, library_id, dept_id', 'numerical', 'integerOnly'=>true),
			array('budget_code', 'length', 'max'=>25),
			array('name', 'length', 'max'=>50),
			array('start_date, end_date, date_created, is_active', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, budget_code, name, start_date, end_date, date_created, created_by, library_id, dept_id, is_active', 'safe', 'on'=>'search'),
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
			'dept' => array(self::BELONGS_TO, 'Department', 'dept_id'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
			'acqPurchaseOrderItems' => array(self::HAS_MANY, 'AcqPurchaseOrderItem', 'budget_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'budget_code' => 'Budget Code',
			'name' => 'Name',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'date_created' => 'Date Created',
			'created_by' => 'Created By',
			'library_id' => 'Library',
			'dept_id' => 'Dept',
			'is_active' => 'Is Active',
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
		$criteria->compare('budget_code',$this->budget_code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}