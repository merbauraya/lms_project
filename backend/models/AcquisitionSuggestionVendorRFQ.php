<?php

/**
 * This is the model class for table "acq_suggestion_vendor_RFQ".
 *
 * The followings are the available columns in table 'acq_suggestion_vendor_RFQ':
 * @property integer $id
 * @property integer $acquisition_suggestion_id
 * @property integer $vendor_id
 * @property string $date_sent
 * @property string $send_to
 * @property string $url_sent
 * @property integer $response
 * @property string $price_per_copy
 * @property string $page_password
 * @property string $response_date
 * @property string $due_date
 * @property integer $currency_id
 *
 * The followings are the available model relations:
 * @property Currency $currency
 * @property Vendor $vendor
 */
class AcquisitionSuggestionVendorRFQ extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcquisitionSuggestionVendorRFQ the static model class
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
		return 'acq_suggestion_vendor_RFQ';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acquisition_suggestion_id, vendor_id, response, currency_id', 'numerical', 'integerOnly'=>true),
			array('send_to, url_sent', 'length', 'max'=>100),
			array('price_per_copy', 'length', 'max'=>6),
			array('page_password', 'length', 'max'=>10),
			array('date_sent, response_date, due_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acquisition_suggestion_id, vendor_id, date_sent, send_to, url_sent, response, price_per_copy, page_password, response_date, due_date, currency_id', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'vendor' => array(self::BELONGS_TO, 'Vendor', 'vendor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'acquisition_suggestion_id' => 'Acquisition Suggestion',
			'vendor_id' => 'Vendor',
			'date_sent' => 'Date Sent',
			'send_to' => 'Send To',
			'url_sent' => 'Url Sent',
			'response' => 'Response',
			'price_per_copy' => 'Price Per Copy',
			'page_password' => 'Page Password',
			'response_date' => 'Response Date',
			'due_date' => 'Due Date',
			'currency_id' => 'Currency',
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
		$criteria->compare('acquisition_suggestion_id',$this->acquisition_suggestion_id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('date_sent',$this->date_sent,true);
		$criteria->compare('send_to',$this->send_to,true);
		$criteria->compare('url_sent',$this->url_sent,true);
		$criteria->compare('response',$this->response);
		$criteria->compare('price_per_copy',$this->price_per_copy,true);
		$criteria->compare('page_password',$this->page_password,true);
		$criteria->compare('response_date',$this->response_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('currency_id',$this->currency_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}