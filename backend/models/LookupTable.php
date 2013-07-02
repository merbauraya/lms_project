<?php

/**
 * This is the model class for table "lookup_table".
 *
 * The followings are the available columns in table 'lookup_table':
 * @property integer $id
 * @property string $category
 * @property string $name
 * @property boolean $active
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property AcquisitionSuggestion[] $acquisitionSuggestions
 * @property AcquisitionSuggestion[] $acquisitionSuggestions1
 */
class LookupTable extends CActiveRecord
{
	const CATEGORY_SUGGESTION_PUBLICATION_PLACE='SUGGEST_PUBLICATION_PLACE';
	const CATEGORY_SUGGESTION_MATERIAL_TYPE='SUGGEST_MATERIAL_TYPE';
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookupTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lookup_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category', 'length', 'max'=>30),
			array('name', 'length', 'max'=>50),
			array('active, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, name, active, date_created', 'safe', 'on'=>'search'),
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
			'acquisitionSuggestions' => array(self::HAS_MANY, 'AcquisitionSuggestion', 'publication'),
			'acquisitionSuggestions1' => array(self::HAS_MANY, 'AcquisitionSuggestion', 'item_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'name' => 'Name',
			'active' => 'Active',
			'date_created' => 'Date Created',
		);
	}
	public function 

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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}