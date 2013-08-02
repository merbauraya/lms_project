<?php

/**
 * This is the base model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $id
 * @property integer $library_id
 * @property string $name
 * @property integer $status
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Library $library
 * @property CatalogDocument[] $catalogDocuments
 * @property Accession[] $accessions
 *
 * @package application.models.base
 * @name BaseLocation
 */
abstract class BaseLocation extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, library_id, name, status, date_created', 'safe', 'on'=>'search'),
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
			'catalogDocuments' => array(self::HAS_MANY, 'CatalogDocument', 'location_id'),
			'accessions' => array(self::HAS_MANY, 'Accession', 'location_id'),
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
			'name' => 'Name',
			'status' => 'Status',
			'date_created' => 'Date Created',
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
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}