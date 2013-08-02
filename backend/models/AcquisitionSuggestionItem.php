<?php

/**
 * This is the model class for table "acquisition_suggestion_item".
 *
 * The followings are the available columns in table 'acquisition_suggestion_item':
 * @property integer $id
 * @property integer $item_number
 * @property string $isbn_10
 * @property string $isbn_13
 * @property string $author
 * @property string $title
 * @property integer $year
 * @property string $edition
 * @property integer $number_of_copy
 * @property integer $currency_id
 * @property string $price
 * @property string $local_price
 * @property string $note
 * @property integer $acq_suggestion_id
 * @property integer $publication_type
 * @property integer $material_type
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property AcquisitionSuggestion $acqSuggestion
 * @property Currency $currency
 */
class AcquisitionSuggestionItem extends CActiveRecord
{
	/* item status */
	const ITEM_STATUS_NEW = 1;
	const ITEM_STATUS_REJECTED = 2;
	const ITEM_STATUS_PROMOTED = 3; //promoted to request
	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcquisitionSuggestionItem the static model class
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
		return 'acq_suggestion_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_number, number_of_copy, currency_id, acq_suggestion_id, publication_type, material_type, status_id,copy', 'numerical', 'integerOnly'=>true),
			array('isbn_13', 'length', 'max'=>15),
			array('isbn', 'length', 'max'=>10),
        		array('author', 'length', 'max'=>70),
        		array('year', 'length', 'max'=>30),
			array('edition', 'length', 'max'=>40),
			array('title', 'length', 'max'=>100),
			array('publisher','length','max'=>60),
			array('number_of_copy', 'required'),
			array('price,local_price', 'type', 'type'=>'float'),
			array('price, local_price', 'length', 'max'=>10),
			array('isbn,id, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_number, isbn, isbn_13, author, title, year, edition, acq_suggestion_id, publication_type, material_type, status_id', 'safe', 'on'=>'search'),
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
			'acqSuggestion' => array(self::BELONGS_TO, 'AcquisitionSuggestion', 'acq_suggestion_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_number' => 'Item Number',
			'isbn_10' => 'Isbn 10',
			'isbn_13' => 'Isbn 13',
			'author' => 'Author',
			'title' => 'Title',
			'year' => 'Year',
			'edition' => 'Edition',
			'number_of_copy' => 'Number Of Copy',
			'currency_id' => 'Currency',
			'price' => 'Price',
			'local_price' => 'Local Price',
			'note' => 'Note',
			'acq_suggestion_id' => 'Acq Suggestion',
			'publication_type' => 'Publication Type',
			'material_type' => 'Material Type',
			'status_id' => 'Status',
			'publisher' => 'Publisher',
			'copy' => 'No. of Copy'
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
		$criteria->compare('isbn_10',$this->isbn_10,true);
		$criteria->compare('isbn_13',$this->isbn_13,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('edition',$this->edition,true);
		$criteria->compare('number_of_copy',$this->number_of_copy);
		$criteria->compare('acq_suggestion_id',$this->acq_suggestion_id);
		$criteria->compare('publication_type',$this->publication_type);
		$criteria->compare('material_type',$this->material_type);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	* Load all items according to the given acquisition suggestion id
	* @param integer $suggestion_id - suggestion id to be loaded
	* 
	*/
	public function loadBySuggestionID($suggestion_id)
	{
				
		$item=AcquisitionSuggestionItem::model()->findAllByAttributes(
							array(),
							$condition = 'acq_suggestion_id = :suggestion_id',
							$params = array(':suggestion_id' => $suggestion_id));
		
							
							 
							
		if ($item===null)
		{
			$item = new AcquisitionSuggestionItem();
			$item->acq_suggestion_id = $suggestion_id;
		}
		
		return $item;
	}
	/**
	* Delete existing item as specified in itemsPK param
	* @param integer $suggestion_id
	* @param integer $itemsPK
	* 
	*/
	public function deleteOldItems($suggestion_id,$itemsPK)
	{
		$criteria = new CDbCriteria;
		$criteria->addNotInCondition('id', $itemsPK);
        $criteria->addCondition("acq_suggestion_id= {$suggestion_id}");
 
        $this::model()->deleteAll($criteria); 
	
	}
	 public function behaviors()
	{
    	return array('datetimeI18NBehavior' =>
					array('class' => 'common.extensions.DateTimeI18NBehavior')); 
	}

}