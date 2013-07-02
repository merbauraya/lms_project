<?php

/**
 * This is the base model class for table "marc_subfield".
 *
 * The followings are the available columns in table 'marc_subfield':
 * @property string $tag
 * @property string $subfield
 * @property string $loc_desc
 * @property string $help_text
 * @property boolean $repeatable
 * @property boolean $mandatory
 * @property string $authorised_value
 * @property string $authtypecode
 * @property string $value_builder
 * @property integer $isurl
 * @property integer $hidden
 * @property string $frameworkcode
 * @property string $link
 * @property string $default_value
 * @property string $link_alt_text
 *
 * @package application.models.base
 * @name BaseMarcSubfield
 */
abstract class BaseMarcSubfield extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'marc_subfield';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isurl, hidden', 'numerical', 'integerOnly'=>true),
			array('tag', 'length', 'max'=>3),
			array('subfield', 'length', 'max'=>1),
			array('loc_desc, help_text', 'length', 'max'=>255),
			array('authorised_value, authtypecode', 'length', 'max'=>20),
			array('value_builder, link', 'length', 'max'=>80),
			array('frameworkcode', 'length', 'max'=>4),
			array('link_alt_text', 'length', 'max'=>50),
			array('repeatable, mandatory, default_value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tag, subfield, loc_desc, help_text, repeatable, mandatory, authorised_value, authtypecode, value_builder, isurl, hidden, frameworkcode, link, default_value, link_alt_text', 'safe', 'on'=>'search'),
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
			'tag' => 'Tag',
			'subfield' => 'Subfield',
			'loc_desc' => 'Loc Desc',
			'help_text' => 'Help Text',
			'repeatable' => 'Repeatable',
			'mandatory' => 'Mandatory',
			'authorised_value' => 'Authorised Value',
			'authtypecode' => 'Authtypecode',
			'value_builder' => 'Value Builder',
			'isurl' => 'Isurl',
			'hidden' => 'Hidden',
			'frameworkcode' => 'Frameworkcode',
			'link' => 'Link',
			'default_value' => 'Default Value',
			'link_alt_text' => 'Link Alt Text',
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

		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('subfield',$this->subfield,true);
		$criteria->compare('loc_desc',$this->loc_desc,true);
		$criteria->compare('help_text',$this->help_text,true);
		$criteria->compare('repeatable',$this->repeatable);
		$criteria->compare('mandatory',$this->mandatory);
		$criteria->compare('authorised_value',$this->authorised_value,true);
		$criteria->compare('authtypecode',$this->authtypecode,true);
		$criteria->compare('value_builder',$this->value_builder,true);
		$criteria->compare('isurl',$this->isurl);
		$criteria->compare('hidden',$this->hidden);
		$criteria->compare('frameworkcode',$this->frameworkcode,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('link_alt_text',$this->link_alt_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}