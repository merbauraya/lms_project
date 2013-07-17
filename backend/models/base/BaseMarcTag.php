<?php

/**
 * This is the base model class for table "marc_tag".
 *
 * The followings are the available columns in table 'marc_tag':
 * @property string $tag
 * @property string $loc_description
 * @property string $help_text
 * @property boolean $repeatable
 * @property boolean $mandatory
 * @property string $default_value
 * @property boolean $indicator1
 * @property boolean $indicator2
 * @property string $tag_type
 *
 * The followings are the available model relations:
 * @property MarcSubfield[] $marcSubfields
 * @property MarcSubfield[] $marcSubfields1
 *
 * @package application.models.base
 * @name BaseMarcTag
 */
abstract class BaseMarcTag extends LmActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'marc_tag';
	}
    public function primaryKey()
    {
        return 'tag,tag_type';
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag, tag_type', 'required'),
			array('tag', 'length', 'max'=>3),
			array('loc_description, default_value', 'length', 'max'=>255),
			array('tag_type', 'length', 'max'=>6),
			array('help_text, repeatable, mandatory, indicator1, indicator2', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tag, loc_description, help_text, repeatable, mandatory, default_value, indicator1, indicator2, tag_type', 'safe', 'on'=>'search'),
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
			'subfields' => array(self::HAS_MANY, 'MarcSubfield', 'tag,tag_type'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tag' => 'Tag',
			'loc_description' => 'Loc Description',
			'help_text' => 'Help Text',
			'repeatable' => 'Repeatable',
			'mandatory' => 'Mandatory',
			'default_value' => 'Default Value',
			'indicator1' => 'Indicator1',
			'indicator2' => 'Indicator2',
			'tag_type' => 'Tag Type',
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
		$criteria->compare('loc_description',$this->loc_description,true);
		$criteria->compare('help_text',$this->help_text,true);
		$criteria->compare('repeatable',$this->repeatable);
		$criteria->compare('mandatory',$this->mandatory);
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('indicator1',$this->indicator1);
		$criteria->compare('indicator2',$this->indicator2);
		$criteria->compare('tag_type',$this->tag_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
