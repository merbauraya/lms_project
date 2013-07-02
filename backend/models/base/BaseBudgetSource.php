<?php

/**
 * This is the base model class for table "budget_source".
 *
 * The followings are the available columns in table 'budget_source':
 * @property integer $id
 * @property string $name
 * @property integer $library_id
 * @property boolean $is_active
 * @property string $date_created
 * @property string $note
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Library $library
 *
 * @package application.models.base
 * @name BaseBudgetSource
 */
abstract class BaseBudgetSource extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budget_source';
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
			array('library_id, created_by', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('is_active, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, library_id, is_active, date_created, note, created_by', 'safe', 'on'=>'search'),
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
			'patron' => array(self::BELONGS_TO, 'Patron', 'created_by'),
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
			'library_id' => 'Library',
			'is_active' => 'Is Active',
			'date_created' => 'Date Created',
			'note' => 'Note',
			'created_by' => 'Created By',
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
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}