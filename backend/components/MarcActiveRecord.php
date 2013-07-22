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
    
    const CATALOGING_AGENCY='MARC_CATALOGING_AGENCY';
    
    public $Marc;
    
  
    
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
	public function getISSN()
	{
	    return $this->getNRData('022','a');
	}
	public function getAuthor()
	{
	    return $this->geNRData('100','a');
	}
	private function _validMarc()
	{
		if ($this->Marc == null)
			throw new Exception('Marc Object is not set');
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
   public function getData($tag,$subField)
   {
   		if ($this->Marc == null)
			throw new Exception('Marc Object is not set');
		
		$_data = array();
		$_tag = $this->Marc->getField($tag);
		if (isset($_tag))
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
		}	
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
}

?>
