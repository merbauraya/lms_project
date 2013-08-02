<?php

/**
 * This is the base model class for table "copy_cataloging_resource".
 *
 * The followings are the available columns in table 'copy_cataloging_resource':
 * @property integer $id
 * @property integer $source_type
 * @property string $url
 * @property boolean $is_active
 * @property string $date_created
 * @property integer $port
 * @property string $database
 *
 * @package application.models.base
 * @name BaseCopyCatalogingResource
 */
abstract class BaseCopyCatalogingResource extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'copy_cataloging_resource';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_type, port', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>100),
			array('database', 'length', 'max'=>30),
			array('is_active, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, source_type, url, is_active, date_created, port, database', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'source_type' => 'Source Type',
			'url' => 'Url',
			'is_active' => 'Is Active',
			'date_created' => 'Date Created',
			'port' => 'Port',
			'database' => 'Database',
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
		$criteria->compare('source_type',$this->source_type);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('port',$this->port);
		$criteria->compare('database',$this->database,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}