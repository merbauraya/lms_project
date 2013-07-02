<?php

/**
 * This is the base model class for table "budget_transaction".
 *
 * The followings are the available columns in table 'budget_transaction':
 * @property integer $id
 * @property integer $budget_account_id
 * @property integer $library_id
 * @property string $trans_code
 * @property string $trans_date
 * @property string $trans_amount
 * @property string $date_created
 * @property integer $created_by
 * @property integer $budget_source_id
 *
 * The followings are the available model relations:
 * @property Library $library
 * @property BudgetTransactionType $transCode
 *
 * @package application.models.base
 * @name BaseBudgetTransaction
 */
abstract class BaseBudgetTransaction extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budget_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('budget_account_id, library_id, created_by, budget_source_id', 'numerical', 'integerOnly'=>true),
			array('trans_code', 'length', 'max'=>20),
			array('trans_amount', 'length', 'max'=>7),
			array('trans_date, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, budget_account_id, library_id, trans_code, trans_date, trans_amount, date_created, created_by, budget_source_id', 'safe', 'on'=>'search'),
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
			'transCode' => array(self::BELONGS_TO, 'BudgetTransactionType', 'trans_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'budget_account_id' => 'Budget Account',
			'library_id' => 'Library',
			'trans_code' => 'Trans Code',
			'trans_date' => 'Trans Date',
			'trans_amount' => 'Trans Amount',
			'date_created' => 'Date Created',
			'created_by' => 'Created By',
			'budget_source_id' => 'Budget Source',
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
		$criteria->compare('budget_account_id',$this->budget_account_id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('trans_code',$this->trans_code,true);
		$criteria->compare('trans_date',$this->trans_date,false);
		$criteria->compare('trans_amount',$this->trans_amount,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('budget_source_id',$this->budget_source_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}