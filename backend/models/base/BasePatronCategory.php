<?php

/**
 * This is the base model class for table "patron_category".
 *
 * The followings are the available columns in table 'patron_category':
 * @property integer $id
 * @property string $name
 * @property string $date_created
 * @property string $date_modified
 * @property integer $library_id
 * @property boolean $is_active
 *
 * The followings are the available model relations:
 * @property Library $library
 * @property CirRule[] $cirRules
 *
 * @package application.models.base
 * @name BasePatronCategory
 */
abstract class BasePatronCategory extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'patron_category';
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
			array('library_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('date_created, date_modified, is_active', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, date_created, date_modified, library_id, is_active', 'safe', 'on'=>'search'),
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
			'cirRules' => array(self::HAS_MANY, 'CirRule', 'patron_category_id'),
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
			'date_created' => 'Date Created',
			'date_modified' => 'Date Modified',
			'library_id' => 'Library',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}