<?php

/**
 * This is the base model class for table "catalog".
 *
 * The followings are the available columns in table 'catalog':
 * @property integer $id
 * @property string $desc
 * @property string $date_created
 * @property string $date_modified
 * @property integer $material_type_id
 * @property string $approved_on
 * @property integer $created_by
 * @property integer $approved_by
 * @property integer $source
 * @property string $title_245a
 * @property string $publisher
 * @property string $edition
 * @property string $year_publish
 * @property integer $personal_name_id
 * @property integer $meeting_name_id
 * @property integer $corporate_name_id
 * @property string $author_100a
 * @property string $title_245c
 * @property string $marc_xml
 * @property string $control_number
 * @property boolean $released
 * @property string $isbn_10
 * @property string $isbn_13
 * @property boolean $opac_released
 * @property string $issn
 * @property boolean $indexed
 * @property string $indexed_on
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property CatalogSubject[] $catalogSubjects
 * @property CatalogItem[] $catalogItems
 * @property CatalogItem[] $catalogItems1
 * @property CatalogItemInfo[] $catalogItemInfos
 * @property Subscription[] $subscriptions
 * @property AcqPurchaseOrderItem[] $acqPurchaseOrderItems
 * @property AcqSuggestionItem[] $acqSuggestionItems
 * @property Serial[] $serials
 * @property MarcTypeOfRecord $materialType
 * @property MarcUploadItem[] $marcUploadItems
 *
 * @package application.models.base
 * @name BaseCatalog
 */
abstract class BaseCatalog extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_type_id, created_by, approved_by, source, personal_name_id, meeting_name_id, corporate_name_id, modified_by', 'numerical', 'integerOnly'=>true),
			array('desc', 'length', 'max'=>100),
			array('publisher, edition, year_publish, author_100a', 'length', 'max'=>200),
			array('control_number, isbn_10, isbn_13', 'length', 'max'=>50),
			array('issn', 'length', 'max'=>20),
			array('date_created, date_modified, approved_on, title_245a, title_245c, marc_xml, released, opac_released, indexed, indexed_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, desc, date_created, date_modified, material_type_id, approved_on, created_by, approved_by, source, title_245a, publisher, edition, year_publish, personal_name_id, meeting_name_id, corporate_name_id, author_100a, title_245c, marc_xml, control_number, released, isbn_10, isbn_13, opac_released, issn, indexed, indexed_on, modified_by', 'safe', 'on'=>'search'),
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
			'catalogSubjects' => array(self::HAS_MANY, 'CatalogSubject', 'catalog_id'),
			'catalogItems' => array(self::HAS_MANY, 'CatalogItem', 'catalog_id'),
			'catalogItems1' => array(self::HAS_MANY, 'CatalogItem', 'control_number'),
			'catalogItemInfos' => array(self::HAS_MANY, 'CatalogItemInfo', 'catalog_id'),
			'subscriptions' => array(self::HAS_MANY, 'Subscription', 'catalog_id'),
			'acqPurchaseOrderItems' => array(self::HAS_MANY, 'AcqPurchaseOrderItem', 'catalog_id'),
			'acqSuggestionItems' => array(self::HAS_MANY, 'AcqSuggestionItem', 'catalog_id'),
			'serials' => array(self::HAS_MANY, 'Serial', 'catalog_id'),
			'materialType' => array(self::BELONGS_TO, 'MarcTypeOfRecord', 'material_type_id'),
			'marcUploadItems' => array(self::HAS_MANY, 'MarcUploadItem', 'catalog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'desc' => 'Desc',
			'date_created' => 'Date Created',
			'date_modified' => 'Date Modified',
			'material_type_id' => 'Material Type',
			'approved_on' => 'Approved On',
			'created_by' => 'Created By',
			'approved_by' => 'Approved By',
			'source' => 'Source',
			'title_245a' => 'Title 245a',
			'publisher' => 'Publisher',
			'edition' => 'Edition',
			'year_publish' => 'Year Publish',
			'personal_name_id' => 'Personal Name',
			'meeting_name_id' => 'Meeting Name',
			'corporate_name_id' => 'Corporate Name',
			'author_100a' => 'Author 100a',
			'title_245c' => 'Title 245c',
			'marc_xml' => 'Marc Xml',
			'control_number' => 'Control Number',
			'released' => 'Released',
			'isbn_10' => 'Isbn 10',
			'isbn_13' => 'Isbn 13',
			'opac_released' => 'Opac Released',
			'issn' => 'Issn',
			'indexed' => 'Indexed',
			'indexed_on' => 'Indexed On',
			'modified_by' => 'Modified By',
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
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('material_type_id',$this->material_type_id);
		$criteria->compare('approved_on',$this->approved_on,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('source',$this->source);
		$criteria->compare('title_245a',$this->title_245a,true);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('edition',$this->edition,true);
		$criteria->compare('year_publish',$this->year_publish,true);
		$criteria->compare('personal_name_id',$this->personal_name_id);
		$criteria->compare('meeting_name_id',$this->meeting_name_id);
		$criteria->compare('corporate_name_id',$this->corporate_name_id);
		$criteria->compare('author_100a',$this->author_100a,true);
		$criteria->compare('title_245c',$this->title_245c,true);
		$criteria->compare('marc_xml',$this->marc_xml,true);
		$criteria->compare('control_number',$this->control_number,true);
		$criteria->compare('released',$this->released);
		$criteria->compare('isbn_10',$this->isbn_10,true);
		$criteria->compare('isbn_13',$this->isbn_13,true);
		$criteria->compare('issn',$this->issn,true);
		$criteria->compare('indexed',$this->indexed);
		$criteria->compare('indexed_on',$this->indexed_on,true);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
