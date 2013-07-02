<?php

/**
 * This is the model class for table "setting_document_id".
 *
 * The followings are the available columns in table 'setting_document_id':
 * @property string $document_type
 * @property string $prefix
 * @property string $suffix
 * @property boolean $use_running_number
 * @property boolean $use_leading_zero
 * @property integer $library_id
 */
class DocumentIdSetting extends LmActiveRecord
{
	private static $_items = array();
	const DOC_CATALOG_CONTROL_NO='CATALOG_CONTROL_NO';
	const ITEM_ACCESSION_NO='ITEM_ACCESSION_NO';
	
	public static function formatID($librayID=0,$docType,$runningId)
	{
		if (!isset(self::$_items[$librayID][$docType]))
			self::loadItems($librayID);
		$model = self::$_items[$librayID][$docType];
		$prefix = isset($model->prefix)? $model->prefix : '';
		$suffix = isset($model->suffix) ? $model->suffix : '';
		$useLeadingZero = $model->use_leading_zero;
		//echo $librayID.$docType.$runningId.$model->use_leading_zero;
		
		$docID = $prefix;
		if ($model->use_leading_zero)
			$docID .= str_pad((int)$runningId,$model->leading_zero_count,'0',STR_PAD_LEFT);
		else
			$docID .= $runningId;
		
		
		$docID .=$suffix;
		return $docID;
	
	}
	private static function loadItems($library_id)
	{
		self::$_items[$library_id]=array();
        $models=self::model()->findAll(array(
            'condition'=>'library_id=:library_id',
            'params'=>array(':library_id'=>$library_id)
            
        ));
        foreach($models as $model)
		{
            self::$_items[$library_id][$model->document_type]=$model;
			
		}	
	
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentIdSetting the static model class
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
		return 'setting_document_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_type, library_id', 'required'),
			array('library_id', 'numerical', 'integerOnly'=>true),
			array('document_type', 'length', 'max'=>30),
			array('prefix, suffix', 'length', 'max'=>5),
			array('use_running_number, use_leading_zero', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('document_type, prefix, suffix, use_running_number, use_leading_zero, library_id', 'safe', 'on'=>'search'),
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
			'document_type' => 'Document Type',
			'prefix' => 'Prefix',
			'suffix' => 'Suffix',
			'use_running_number' => 'Use Running Number',
			'use_leading_zero' => 'Use Leading Zero',
			'library_id' => 'Library',
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

		$criteria->compare('document_type',$this->document_type,true);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('suffix',$this->suffix,true);
		$criteria->compare('use_running_number',$this->use_running_number);
		$criteria->compare('use_leading_zero',$this->use_leading_zero);
		$criteria->compare('library_id',$this->library_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}