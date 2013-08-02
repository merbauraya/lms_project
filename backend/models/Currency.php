<?php

/**
 * This is the model class for table "currency".
 *
 * The followings are the available columns in table 'currency':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property boolean $is_active
 * @property string $date_created
 * @property string $conversion_rate
 *
 * The followings are the available model relations:
 * @property AcquisitionSuggestion[] $acquisitionSuggestions
 */
class Currency extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Currency the static model class
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
		return 'currency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			array('conversion_rate', 'length', 'max'=>4),
			array('is_active, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, is_active, date_created, conversion_rate', 'safe', 'on'=>'search'),
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
			'acquisitionSuggestions' => array(self::HAS_MANY, 'AcquisitionSuggestion', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'is_active' => 'Is Active',
			'date_created' => 'Date Created',
			'conversion_rate' => 'Conversion Rate',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('conversion_rate',$this->conversion_rate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}