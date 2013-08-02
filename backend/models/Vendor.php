<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $vendor_category_id
 * @property string $url
 * @property string $date_created
 * @property boolean $is_publisher
 * @property boolean $is_binder
 *
 * The followings are the available model relations:
 * @property VendorCategory $vendorCategory
 */
class Vendor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vendor the static model class
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
		return 'vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_category_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>80),
			array('url', 'length', 'max'=>100),
			array('date_created, is_publisher, is_binder', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, vendor_category_id, date_created, is_publisher, is_binder', 'safe', 'on'=>'search'),
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
			'vendorCategory' => array(self::BELONGS_TO, 'VendorCategory', 'vendor_category_id'),
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
			'vendor_category_id' => 'Vendor Category',
			'url' => 'Url',
			'date_created' => 'Date Created',
			'is_publisher' => 'Is Publisher',
			'is_binder' => 'Is Binder',
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
		$criteria->compare('vendor_category_id',$this->vendor_category_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('is_publisher',$this->is_publisher);
		$criteria->compare('is_binder',$this->is_binder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}