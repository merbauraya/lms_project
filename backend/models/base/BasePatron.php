<?php

/**
 * This is the base model class for table "patron".
 *
 * The followings are the available columns in table 'patron':
 * @property integer $id
 * @property string $name
 * @property integer $library_id
 * @property integer $category_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property integer $login_attempts
 * @property string $expiry_date
 * @property string $date_created
 * @property string $date_modified
 * @property integer $created_by
 * @property integer $department_id
 * @property string $mobile_no
 * @property string $staff_no
 * @property integer $status_id
 * @property string $last_login_time
 *
 * The followings are the available model relations:
 * @property BudgetSource[] $budgetSources
 * @property AcqSuggestion[] $acqSuggestions
 * @property CirTransaction[] $cirTransactions
 * @property Department[] $departments
 * @property Course[] $courses
 * @property PatronStatus $status
 * @property MarcUpload[] $marcUploads
 * @property PatronAddress[] $patronAddresses
 * @property Subscription[] $subscriptions
 * @property AcqGoodReceive[] $acqGoodReceives
 * @property AcqPurchaseOrder[] $acqPurchaseOrders
 * @property AcqPurchaseOrder[] $acqPurchaseOrders1
 * @property AcqRequestItem[] $acqRequestItems
 * @property AcqRequestItem[] $acqRequestItems1
 * @property AcqSuggestionItem[] $acqSuggestionItems
 * @property CirTransactionHistory[] $cirTransactionHistories
 * @property MarcImport[] $marcImports
 *
 * @package application.models.base
 * @name BasePatron
 */
abstract class BasePatron extends LmActiveRecord
{
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
			array('name, library_id, username, password,password_repeat', 'required'),
			array('library_id, category_id, login_attempts, created_by, department_id, status_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('username, phone1, phone2, mobile_no', 'length', 'max'=>15),
			array('password,password_repeat', 'length', 'max'=>125),
            array('email', 'length', 'max'=>125),
			array('staff_no', 'length', 'max'=>20),
			array('expiry_date,password_repeat,password, date_created, date_modified, last_login_time', 'safe'),
			 array('password_repeat', 'compare', 'compareAttribute'=>'password'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, library_id, category_id, username, password, email, phone1, phone2, login_attempts, expiry_date, date_created, date_modified, created_by, department_id, mobile_no, staff_no, status_id, last_login_time', 'safe', 'on'=>'search'),
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
			'budgetSources' => array(self::HAS_MANY, 'BudgetSource', 'created_by'),
			'acqSuggestions' => array(self::HAS_MANY, 'AcqSuggestion', 'suggested_by'),
			'cirTransactions' => array(self::HAS_MANY, 'CirTransaction', 'patron_username'),
			'departments' => array(self::HAS_MANY, 'Department', 'created_by'),
			'courses' => array(self::HAS_MANY, 'Course', 'created_by'),
			'status' => array(self::BELONGS_TO, 'PatronStatus', 'status_id'),
			'marcUploads' => array(self::HAS_MANY, 'MarcUpload', 'uploaded_by'),
			'patronAddresses' => array(self::HAS_MANY, 'PatronAddress', 'patron_id'),
			'subscriptions' => array(self::HAS_MANY, 'Subscription', 'created_by'),
			'acqGoodReceives' => array(self::HAS_MANY, 'AcqGoodReceive', 'created_by'),
			'acqPurchaseOrders' => array(self::HAS_MANY, 'AcqPurchaseOrder', 'created_by'),
			'acqPurchaseOrders1' => array(self::HAS_MANY, 'AcqPurchaseOrder', 'modified_by'),
			'acqRequestItems' => array(self::HAS_MANY, 'AcqRequestItem', 'created_by'),
			'acqRequestItems1' => array(self::HAS_MANY, 'AcqRequestItem', 'modified_by'),
			'acqSuggestionItems' => array(self::HAS_MANY, 'AcqSuggestionItem', 'status_update_by'),
			'cirTransactionHistories' => array(self::HAS_MANY, 'CirTransactionHistory', 'patron_username'),
			'marcImports' => array(self::HAS_MANY, 'MarcImport', 'import_by'),
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
			'category_id' => 'Category',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'phone1' => 'Phone1',
			'phone2' => 'Phone2',
			'login_attempts' => 'Login Attempts',
			'expiry_date' => 'Expiry Date',
			'date_created' => 'Date Created',
			'date_modified' => 'Date Modified',
			'created_by' => 'Created By',
			'department_id' => 'Department',
			'mobile_no' => 'Mobile No',
			'staff_no' => 'Staff No',
			'status_id' => 'Status',
			'last_login_time' => 'Last Login Time',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('login_attempts',$this->login_attempts);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('staff_no',$this->staff_no,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('last_login_time',$this->last_login_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
