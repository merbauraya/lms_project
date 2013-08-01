<?php

class ReportModel extends CModel
{
    private $library_id;
    private $daterange;
    
    
    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('library_id', 'numerical', 'integerOnly'=>true),
			array('daterange', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, authority_type_id, date_created, date_modified, created_by, last_modified_by, marc_xml', 'safe', 'on'=>'search'),
		);
	}
    
    
    /**
	 * @return array customized attribute labels (name=>label)
	 */
	
    public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'library_id' => 'Library',
			'date_created' => 'Date Created',
			'date_modified' => 'Date Modified',
			'created_by' => 'Created By',
			'last_modified_by' => 'Last Modified By',
			'marc_xml' => 'Marc Xml',
		);
	}
    /**
	 * Returns the list of all attribute names of the model.
	 * This would return all column names of the table associated with this AR class.
	 * @return array list of attribute names.
	 */
	public function attributeNames()
	{
		//return array_keys($this->getMetaData()->columns);
        return array('library_id','daterange');
	}
    
    public function getAttribute($name)
	{
		if(property_exists($this,$name))
			return $this->$name;
		elseif(isset($this->_attributes[$name]))
			return $this->_attributes[$name];
	}
    public function setAttribute($name,$value)
	{
		if(property_exists($this,$name))
			$this->$name=$value;
		else
			return false;
		return true;
	}
    /**
	 * PHP getter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name)
	{
		return $this->$name;
     
	}
    /**
	 * PHP setter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @param mixed $value property value
	 */
	public function __set($name,$value)
	{
		if($this->setAttribute($name,$value)===false)
		{
			//if(isset($this->getMetaData()->relations[$name]))
			//	$this->_related[$name]=$value;
			//else
				parent::__set($name,$value);
		}
	}


}
