<?php

/**
 * This is the model class for table "patron".
 *
 * The followings are the available columns in table 'patron':
 * @property integer $id
 * @property string $name
 * @property integer $library_id
 * @property integer $patron_category_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 *
 * The followings are the available model relations:
 * @property PatronAddress[] $patronAddresses
 */
class Patron extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Patron the static model class
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
		return 'patron';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id, patron_category_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('username, password, phone1, phone2', 'length', 'max'=>15),
			array('email', 'length', 'max'=>125),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, library_id, patron_category_id, username, password, email, phone1, phone2', 'safe', 'on'=>'search'),
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
			'patronAddresses' => array(self::HAS_MANY, 'PatronAddress', 'patron_id'),
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
			'patron_category_id' => 'Patron Category',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'phone1' => 'Phone1',
			'phone2' => 'Phone2',
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
		$criteria->compare('patron_category_id',$this->patron_category_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}