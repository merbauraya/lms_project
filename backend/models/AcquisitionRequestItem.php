<?php

/**
 * This is the model class for table "acquisition_request_item".
 *
 * The followings are the available columns in table 'acquisition_request_item':
 * @property integer $id
 * @property string $isbn
 * @property string $isbn_13
 * @property string $title
 * @property string $author
 * @property string $edition
 * @property integer $number_of_copy
 * @property integer $currency_id
 * @property string $price
 * @property string $local_price
 * @property string $note
 * @property integer $acq_request_id
 * @property string $date_created
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $modified_date
 * @property string $publication_date
 * @property string $publisher
 * @property integer $status_id
 * @property integer $approved_rejected_by
 * @property integer $rejected_reason
 *
 * The followings are the available model relations:
 * @property AcquisitionRequest $acqRequest
 * @property Patron $createdBy
 * @property Currency $currency
 * @property Patron $modifiedBy
 */
class AcquisitionRequestItem extends CActiveRecord
{
	/*ITEM Status */
	const STATUS_NEW = 1;
	const STATUS_REJECTED = 2;
	const STATUS_APPROVED = 3;
	const STATUS_ONHOLD = 4;
	const STATUS_ORDERED = 5;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcquisitionRequestItem the static model class
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
		return 'acq_request_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number_of_copy, currency_id, acq_request_id, created_by, modified_by, status_id, approved_rejected_by, rejected_reason', 'numerical', 'integerOnly'=>true),
			array('isbn, isbn_13', 'length', 'max'=>15),
			array('title, author', 'length', 'max'=>100),
			array('edition, publisher', 'length', 'max'=>50),
			array('price, local_price', 'length', 'max'=>8),
			array('publication_date', 'length', 'max'=>30),
			array('note, date_created, modified_date', 'safe'),
			array('number_of_copy', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, isbn, isbn_13, title, author, edition, number_of_copy, currency_id, price, local_price, note, acq_request_id, date_created, created_by, modified_by, modified_date, publication_date, publisher, status_id, approved_rejected_by, rejected_reason', 'safe', 'on'=>'search'),
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
			'acqRequest' => array(self::BELONGS_TO, 'AcquisitionRequest', 'acq_request_id'),
			'createdBy' => array(self::BELONGS_TO, 'Patron', 'created_by'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'modifiedBy' => array(self::BELONGS_TO, 'Patron', 'modified_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'isbn' => 'Isbn',
			'isbn_13' => 'Isbn 13',
			'title' => 'Title',
			'author' => 'Author',
			'edition' => 'Edition',
			'number_of_copy' => 'Number Of Copy',
			'currency_id' => 'Currency',
			'price' => 'Price',
			'local_price' => 'Local Price',
			'note' => 'Note',
			'acq_request_id' => 'Acq Request',
			'date_created' => 'Date Created',
			'created_by' => 'Created By',
			'modified_by' => 'Modified By',
			'modified_date' => 'Modified Date',
			'publication_date' => 'Publication Date',
			'publisher' => 'Publisher',
			'status_id' => 'Status',
			'approved_rejected_by' => 'Approved Rejected By',
			'rejected_reason' => 'Rejected Reason',
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
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('isbn_13',$this->isbn_13,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('edition',$this->edition,true);
		$criteria->compare('number_of_copy',$this->number_of_copy);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('local_price',$this->local_price,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('acq_request_id',$this->acq_request_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('publication_date',$this->publication_date,true);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('approved_rejected_by',$this->approved_rejected_by);
		$criteria->compare('rejected_reason',$this->rejected_reason);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on 
	 * the search/filter conditions.
	 * @param integer $libraryId the Library ID the request belong token_get_all
	 * @param integer $deptId the department ID. If the parameter is omitted, all
	 * approved item for this library will be returned
	 */
	 
	public function getApprovedItems($libraryId,$deptId=0)
	{
		$criteria = new CDbCriteria();
		//avoid ambigious column
		$criteria->condition = $this->getTableAlias(false, false) .'.status_id = :status_id';
		$criteria->with = array('acqRequest','acqRequest.department');
		if ($deptId !== 0)
		{
			$criteria->compare(acqRequest.department_id , $deptId);
		}
		$criteria->params = array(':status_id'=>self::STATUS_APPROVED);
		
		return new CActiveDataProvider($this,array(
				'criteria'=>$criteria
			));
	}
	public function searchNewItemByRequestId($ids)
	{
		
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'status_id= :status_id';
		$criteria->params = array(':status_id'=>self::STATUS_NEW);
		$criteria->addInCondition('acq_request_id',$ids);	
		return new  CActiveDataProvider($this, array(
			'criteria'=>$criteria
			
		));
	
	}
	 public function behaviors()
	{
    	return array('datetimeI18NBehavior' =>
					array('class' => 'common.extensions.DateTimeI18NBehavior')); 
	}

}