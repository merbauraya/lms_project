<?php

/**
 * This is the base model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $id
 * @property string $name
 * @property boolean $is_active
 * @property string $date_created
 * @property integer $created_by
 * @property integer $library_id
 *
 * The followings are the available model relations:
 * @property AcqRequest[] $acqRequests
 * @property BudgetAccount[] $budgetAccounts
 * @property AcqSuggestion[] $acqSuggestions
 * @property Patron $createdBy
 * @property Library $library
 *
 * @package application.models.base
 * @name BaseDepartment
 */
abstract class BaseDepartment extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('created_by, library_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>80),
			array('is_active, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, is_active, date_created, created_by, library_id', 'safe', 'on'=>'search'),
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
			'acqRequests' => array(self::HAS_MANY, 'AcqRequest', 'department_id'),
			'budgetAccounts' => array(self::HAS_MANY, 'BudgetAccount', 'dept_id'),
			'acqSuggestions' => array(self::HAS_MANY, 'AcqSuggestion', 'department_id'),
			'createdBy' => array(self::BELONGS_TO, 'Patron', 'created_by'),
			'library' => array(self::BELONGS_TO, 'Library', 'library_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'is_active' => 'Is Active',
			'date_created' => 'Date Created',
			'created_by' => 'Created By',
			'library_id' => 'Library',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('library_id',$this->library_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}