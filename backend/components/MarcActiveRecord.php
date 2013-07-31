<?php
/*
	Wrapper for Marc_Record



*/
require_once('File/MARC.php');
class MarcActiveRecord //extends MarcBase
{
    private $_attributes = array();
    private $_subfields = array();
    private $_indicator = array();
    private $_marcId; //our internal catalog id
    private $_source = Catalog::SOURCE_MARC_IMPORT; //source for our marc record 
    private $_isbn10;
    private $_isbn13;
    const CATALOGING_AGENCY='MARC_CATALOGING_AGENCY';
    
    public $Marc;  //MarcRecord instance
    
  
    
	//constructor
	function __construct($attributes)
    {
        $this->_attributes = $attributes;
        if ($attributes != null)
			$this->parse();
    }
	public static function setMarc($marc)
	{
		$obj = new MarcActiveRecord(null);
		$obj->setMarcRecord($marc);
		return $obj;
	}
    public function setRecordSource($source)
    {
        $this->_source = $source;
        
    }
    /**
     * set Marc Tag 001 internal id
     * Normally this is called after system id is obtained
     */
    public function setMarcId($id)
    {
       $this->_marcId = $id;
       $this->Marc->appendField(new File_MARC_Control_Field('001',$id));
        
    }
	/**
	*	Set Marc object
	*
	*
	*/
	public function setMarcRecord($marc)
	{
		$this->Marc = $marc;
	}
	public function getTitle()
	{
		return $this->getNRData('245','a');
	}
	public function getISBN()
	{
		return $this->getNRData('020','a');
        
	}
    public function getISBN_10()
    {
        if (!isset($this->_isbn10))
            $this->parseISBN();
        return $this->_isbn10;
    }
    public function getISBN_13()
    {
        if (!isset($this->_isbn13))
            $this->parseISBN();
        return $this->_isbn13;
    }
    private function parseISBN()
    {
        
        $data = $this->getData('020','a');
        if (count($data) == 0)
            return;
        foreach($data as $key=>$value)
        {
            
            $val = LmUtil::stripNonNumeric($value);
            if (strlen($val) == 13)
                $this->_isbn13 = $value;
            if (strlen($val) == 10)
                $this->_isbn10 = $value;
        }
        
    }
    
	public function getISSN()
	{
	    return $this->getNRData('022','a');
	}
	public function getAuthor()
	{
	    return $this->getNRData('100','a');
	}
	private function _validMarc()
	{
		if ($this->Marc == null)
			throw new Exception('Marc Object is not set');
	}
	public function getSubject650_a()
    {
        return $this->getData('650','a');
        
    }
    public function getSubject630_a()
    {
        return $this->getData('630','a');
    }
    private function parse()
    {
        $this->Marc = new File_MARC_Record;
        foreach ($this->_attributes as $key => $value) {
            //we have key in the following format
            //1. control field : Marc[tag-counter]
            //2. subfield  : Marc[tag-subfield-counter]
            //3. Indicator : Marc[indi1/2-tag-subfield-counter]
           
            //start constructing data
            $_tmp     = str_replace(']', '', str_replace('Marc[', '', $key));
            $_tmpB    = explode('-', $_tmp);
            
            switch (count($_tmpB))
            {
                case 2:
                    $this->parseControlField($_tmpB,$value);
                    break;
                    
                case 3:
                    $this->parseSubField($_tmpB,$value);
                    break;
                    
                case 4:
                    $this->parseIndicator($_tmpB,$value);
                    break;
            }
         
        }
        //loop through the attributes and construct marc
        foreach ($this->_subfields as $tagkey=>$subfields)
        {
            //echo ($tagkey.'<br>');
            //var_dump($subfields);
            
            
            $tag = $subfields['tag'];
            $subfield=$subfields['subfield'];
            //echo $key . '::' . $value;
            if (array_key_exists($tagkey,$this->_indicator))
            {
                //we should have indi1 and indi2
                $indi1 = $this->_indicator[$tagkey]['indi1'];
                $indi2 = $this->_indicator[$tagkey]['indi2'];
                //we have enough info to build marc record
                //$this->Marc->appendField(new File_MARC_Data_Field($tag,$subfield, $subfields['value'], $indi1, $indi2));
                $this->Marc->appendField(new File_MARC_Data_Field($tag, array(
                    new File_MARC_Subfield($subfield, $subfields['value']),
                    ), $indi1, $indi2
                ));                
            }else
            {
                //must be control field
                
            }
		
			
        }
        //set cataloging agency
        $this->Marc->appendField(new File_MARC_Control_Field('003',Yii::app()->config->get(self::CATALOGING_AGENCY)));
        print $this->Marc;
    }
    private function parseControlField($meta,$value)
    {
        //we have
        // 0 -tag
        // 1 - counter
        $tag = $meta[0];
        if ((int)$tag==00)
            $this->Marc->setLeader($value);
        else    
            $this->Marc->appendField(new File_MARC_Control_Field($tag,$value));
    }
    private function parseSubField($meta,$value)
    {
        
        //we have 
        //idx 0 = tag
        //idx 1 = subfield
        //idx 2 = counter 
        $tag      = $meta[0];
        $n = $meta[2];
        $subfield = $meta[1];
        $arrKey = $tag.'-'.$n.'-'.$subfield;
        
        if (array_key_exists($arrKey,$this->_subfields))
            $this->_subfields[$arrKey]=array_merge($this->_subfields[$arrKey],array('tag'=>$tag,'subfield'=>$subfield,'value'=>$value));
        else
            $this->_subfields[$arrKey] = array('tag'=>$tag,'subfield'=>$subfield,'value'=>$value);
        
        
    }
    private function parseIndicator($meta,$value)
    {
        //we should have the following
        //0 - indicator name (indi1 or indi2)
        //1 - tag
        //2 - subfield code
        //3 - counter
        
        $n = $meta[3];
        $tag = $meta[1];
        $indicator = $meta[0];
        $arrKey = $tag.'-'.$n.'-'.$meta[2];//key should match _attributes array
        //check if we already have an indicator for this tag + subfield
        if (array_key_exists($arrKey,$this->_indicator))
            $this->_indicator[$arrKey] =array_merge($this->_indicator[$arrKey],array($meta[0]=>$value));
        else
            $this->_indicator[$arrKey] = array($meta[0]=>$value);
        
    }
    /**
     * 
     * Return marc data for the given subfield and tag
     * If successful(e.g. tag & subfield exists), an array of data will be returned, else null is returned
     * It is caller resposibility to browse the returned array to get the data
     * 
     */ 
    public function getData($tag,$subField)
    {
   		if ($this->Marc == null)
			throw new Exception('Marc Object is not set');
		
		$_data = array();
		$_tags = $this->Marc->getFields($tag);
		foreach ($_tags as $_tag)
        {
            $_subfield = $_tag->getSubFields($subField);
			foreach($_subfield as $key=>$value)
			{
				$_data[] = $value->getData();
			}
            
        }
        return $_data;
        /*
        
        if ($_tag)
		{
			$_subfield = $_tag->getSubFields($subField);
			foreach($_subfield as $key=>$value)
			{
				$_data[] = $value->getData();
			}
			return $_data;
		}else
		{
			return array(NULL);
		}*/	
   }
   /*
   *	Get non repeatable data
   *
   *
   */
   public function getNRData($tag,$subfield)
   {
   		if ($this->Marc == null)
			throw new Exception('Marc Object is not set');
		$_tag = $this->Marc->getField($tag);
		if ($_tag)
		{
			$_subfield = $_tag->getSubFields($subfield);
			if (isset($_subfield[0]))
			{
				return $_subfield[0]->getData();
			}
			else
			{
				return NULL;
			}
				
		}else
		{
			return NULL;
		}	
    }
    /**
     * Save Marc info as new catalog.
     * If successful, new catalog will be returned, otherwise error will be thrown
     * 
     * 
     * 
     */ 
    public function saveAsNewCatalog()
    {
        if (!$this->Marc)
            throw new Exception('Marc record is not set');
        
        // we need to edit marc record to ensure consistencty
        //and meet our schema requirement
        //1st. get the id for the catalog
        
        try
        {
            $catalog = new Catalog();
            $catalog->date_created = LmUtil::dBCurrentDateTime();
            $catalog->created_by = LmUtil::UserId();
            $catalog->save(); //
            
            //delete original 001 control field so we replace it with our own
            $this->Marc->deleteFields('001',false);
            $mid = new File_MARC_Control_Field('001',$catalog->id);
            $this->Marc->appendField($mid);
            
            $catalog->control_number = DocumentIdSetting::formatID(0,DocumentIdSetting::DOC_CATALOG_CONTROL_NO,$catalog->id);
				
            $catalog->title_245a = $this->getTitle();
            $catalog->isbn_10 = $this->getISBN_10();
            $catalog->isbn_13 = $this->getISBN_13();
            $catalog->issn = $this->getISSN();
            $catalog->author_100a = $this->getAuthor();
            $catalog->source = $this->_source ;//Catalog::SOURCE_MARC_IMPORT;
            $catalog->marc_xml = $this->Marc->toXML();
            $leaderParser = new MarcLeaderParser($this->Marc);
            $catalog->catalog_format_id = $leaderParser->getFormat();
            $catalog->bibliographic_level = $leaderParser->getBibliographicLevel();
            $catalog->save();
            return $catalog;
        } catch (CException $ex)
        {
            LmUtil::logError('Error creating new catalog : ' .$ex->getMessage(),'MarcActiveRecord'.'.'.'saveAsNewCatalog');
            throw $ex;
        }
        
        
    }
}

?>
