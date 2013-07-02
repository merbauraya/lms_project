<?php

/**
 * This is the model class for table "acquisition_suggestion".
 *
 * The followings are the available columns in table 'acquisition_suggestion':
 * @property integer $id
 * @property integer $suggested_by
 * @property string $suggest_date
 * @property integer $status_id
 * @property string $notes
 * @property integer $budget_id
 * @property integer $library_id
 * @property string $staff_no
 * @property integer $publication
 * @property integer $item_type
 * @property string $ebook_name
 * @property string $suggestor_email
 * @property string $suggestor_hp
 * @property string $suggestor_office_no
 * @property integer $faculty_dept
 *
 * The followings are the available model relations:
 * @property AcquisitionSuggestionItem[] $acquisitionSuggestionItems
 */
class AcquisitionSuggestion extends CActiveRecord
{
	//suggestion status
	const SUGGESTION_NEW = 1;
	
	const DOCUMENT_TYPE= 'ACQ_SUGGESTION';

	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcquisitionSuggestion the static model class
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
		return 'acq_suggestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suggested_by, status_id, budget_id, library_id, publication, item_type, department_id', 'numerical', 'integerOnly'=>true),
			array('staff_no', 'length', 'max'=>15),
			array('ebook_name', 'length', 'max'=>70),
			array('description', 'length', 'max'=>50),
			array('suggest_date,suggested_by,department_id,library_id,budget_id', 'required'),
			array('suggestor_email', 'length', 'max'=>80),
			array('suggestor_hp, suggestor_office_no', 'length', 'max'=>12),
			array('suggest_date, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, suggested_by, suggest_date, status_id, budget_id, library_id, staff_no, publication, item_type, department_id', 'safe', 'on'=>'search'),
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
			'acquisitionSuggestionItems' => array(self::HAS_MANY, 'AcquisitionSuggestionItem', 'acq_suggestion_id'),
			'patron' => array(self::BELONGS_TO,'Patron','suggested_by'),
			'budget' => array(self::BELONGS_TO,'BudgetAccount','budget_id'),
			'department' =>array(self::BELONGS_TO,'Department','department_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'suggested_by' => 'Suggested By',
			'suggest_date' => 'Suggest Date',
			'status_id' => 'Status',
			'notes' => 'Notes',
			'budget_id' => 'Budget',
			'library_id' => 'Library',
			'staff_no' => 'Staff No',
			'publication' => 'Publication',
			'item_type' => 'Item Type',
			'ebook_name' => 'Ebook Name',
			'suggestor_email' => 'Suggestor Email',
			'suggestor_hp' => 'Suggestor Hp',
			'suggestor_office_no' => 'Suggestor Office No',
			'department_id' => 'Faculty Dept',
			'description' => 'Suggestion Name',
		);
	}
	public function getActiveSuggestion($library_id,$dept_id)
	{
		$criteria = new CDbCriteria;
		$criteria->select='id,suggest_date,text_id ';
		$criteria->condition='status_id = :suggest_status';
		$criteria->addCondition('library_id= :library_id');
		$criteria->addCondition('department_id= :dept_id');
		$criteria->params[':suggest_status'] = self::SUGGESTION_NEW;
		$criteria->params[':library_id']= $library_id;
		$criteria->params[':dept_id']= $dept_id;
		return AcquisitionSuggestion::model()->findAll($criteria);
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
		$criteria->compare('suggested_by',$this->suggested_by);
		$criteria->compare('suggest_date',$this->suggest_date,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('budget_id',$this->budget_id);
		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('staff_no',$this->staff_no,true);
		$criteria->compare('publication',$this->publication);
		$criteria->compare('item_type',$this->item_type);
		$criteria->compare('ebook_name',$this->ebook_name,true);
		$criteria->compare('suggestor_email',$this->suggestor_email,true);
		$criteria->compare('suggestor_hp',$this->suggestor_hp,true);
		$criteria->compare('suggestor_office_no',$this->suggestor_office_no,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->with =array('budget','patron');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	 public function behaviors()
	{
    	return array('datetimeI18NBehavior' =>
					array('class' => 'common.extensions.DateTimeI18NBehavior')); 
	}

}