<?php
/*
	Wrapper for Marc_Record



*/
require_once('File/MARC.php');
class MarcActiveRecord extends MarcBase
{
    private $_attributes = array();
    public $Marc;
    
    //main entry
    /*
    private $_100a_personal_name;
    private $_100b_numeration;
    private $_100c_title;
    private $_100d_date_associated; */
    
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
	public function getPublicationDate()
	{
	
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
            //Marc[245-10-c-33]
            //245 = tag
            //1 - indicator 1
            //0 - indicator 2
            //c - subfield
            //33 - merely counter to ensure uniqueness
            //start constructing data
            $_tmp     = str_replace(']', '', str_replace('Marc[', '', $key));
            $_tmpB    = explode('-', $_tmp);
            //we have 
            //idx 0 = tag
            //idx 1 = indicator
            //idx 2 = subfield
            //idx 3 = counter --not used
            $tag      = $_tmpB[0];
            $indi1    = substr($_tmpB[1], 0, 1);
            $indi2    = substr($_tmpB[1], 1, 1);
            $subfield = $_tmpB[2];
            $this->Marc->appendField(new File_MARC_Data_Field($tag, array(
                new File_MARC_Subfield($subfield, $value)
            ), $indi1, $indi2));
            
            
            
            
        }
        //personal name;
        
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
   *	Get non repeatble data
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
