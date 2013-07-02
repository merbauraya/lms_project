<?php

/**
 * This is the model class for table "acquisition_request".
 *
 * The followings are the available columns in table 'acquisition_request':
 * @property integer $id
 * @property integer $requested_by
 * @property string $request_date
 * @property integer $status_id
 * @property integer $currency_id
 * @property integer $vendor_id
 * @property string $notes
 * @property integer $budget_id
 * @property integer $library_id
 * @property integer $request_mode_id
 * @property integer $approved_by
 * @property string $approved_date
 * @property integer $rejected_by
 * @property string $rejected_reason
 * @property string $rejected_date
 * @property string $expected_purchase_date
 *
 * The followings are the available model relations:
 * @property AcquisitionRequestItem[] $acquisitionRequestItems
 * @property RequestMode $requestMode
 */
class AcquisitionRequest extends CActiveRecord
{
	//const
	const REQUEST_NEW = 1; //new request
	const REQUEST_ACTIONED = 2; //request has been actioned (rejected or approved)
	
	private static $_publication_type = array(
			'1' => 'Local Publication',
			'2'=>'Oversea',
			'3'=>'Mixed Publication');
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcquisitionRequest the static model class
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
		return 'acq_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('requested_by, status_id, currency_id, vendor_id, budget_id, library_id, request_mode_id, approved_by, department_id,rejected_by', 'numerical', 'integerOnly'=>true),
			array('rejected_reason', 'length', 'max'=>50),
			
			array('request_date, notes, approved_date, rejected_date, expected_purchase_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, requested_by, request_date, status_id, currency_id,  budget_id, library_id, approved_by, approved_date, rejected_by, rejected_reason,department_id',  'safe', 'on'=>'search'),
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
			'acquisitionRequestItems' => array(self::HAS_MANY, 'AcquisitionRequestItem', 'acq_request_id'),
			'requestMode' => array(self::BELONGS_TO, 'RequestMode', 'request_mode_id'),
			'patron' => array(self::BELONGS_TO,'Patron','requested_by'),
			'department'=>array(self::BELONGS_TO,'Department','department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'requested_by' => 'Requested By',
			'request_date' => 'Request Date',
			'status_id' => 'Status',
			'currency_id' => 'Currency',
			'vendor_id' => 'Vendor',
			'notes' => 'Notes',
			'budget_id' => 'Budget',
			'library_id' => 'Library',
			'request_mode_id' => 'Request Mode',
			'approved_by' => 'Approved By',
			'approved_date' => 'Approved Date',
			'rejected_by' => 'Rejected By',
			'rejected_reason' => 'Rejected Reason',
			'rejected_date' => 'Rejected Date',
			'expected_purchase_date' => 'Expected Purchase Date',
			'department_id' =>'Faculty',
			'description' =>'Request name'
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
		$criteria->compare('requested_by',$this->requested_by);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('status_id',$this->status);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('vendor_id',$this->vendor_id);
		//$criteria->compare('notes',$this->notes,true);
		$criteria->compare('budget_id',$this->budget_id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('request_mode_id',$this->request_mode_id);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('approved_date',$this->approved_date,true);
		$criteria->compare('rejected_by',$this->rejected_by);
		$criteria->compare('rejected_reason',$this->rejected_reason,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getPublicationType()
	{
		return self::$_publication_type;
	}
	 public function behaviors()
	{
    	return array('datetimeI18NBehavior' =>
					array('class' => 'common.extensions.DateTimeI18NBehavior')); 
	}

}