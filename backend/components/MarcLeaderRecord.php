<?php
/**
* Provide default marc leader related values
*/
class MarcLeaderRecord 
{
	
	const RECORD_LENGTH=4;
	
    private $leader;
	private $source;
	private $recordlength; 
	private $recordstatus; //05
	private $typeofrecord; //06
	private $bibliographiclevel; //07
	private $typeofcontrol; //08
    private $charactercodingscheme;//09
    private $indicatorcount;//10
    private $subfieldcodecount;//11
    private $baseaddressdata ; //12-16
	private $encodinglevel; //17
	private $descriptivecatalogform; //18
	private $multipartresourcerecord; //19
    private $att=array();
    //const $entrymap = '4500' //20-23
	function __construct()
	{
		//$this->source=$source;
	
	}
	public function __set($property, $value) 
	{
		if (property_exists($this, $property)) 
        {
			$this->$property = $value;
		}

		//return $this;
	}
	public function getLeader()
    {
        
        $this->leader = str_repeat(' ',24);
        $this->leader = substr_replace($this->leader,$this->recordstatus,5,1);
        $this->leader = substr_replace($this->leader,$this->typeofrecord,6,1);
        $this->leader = substr_replace($this->leader,$this->bibliographiclevel,7,1);
        $this->leader = substr_replace($this->leader,$this->typeofcontrol,8,1);
        $this->leader = substr_replace($this->leader,'a',9,1);
        $this->leader = substr_replace($this->leader,'2',10,1);
        $this->leader = substr_replace($this->leader,'2',11,1);
        $this->leader = substr_replace($this->leader,'    ',12,4);
        $this->leader = substr_replace($this->leader,$this->encodinglevel,17,1);
        $this->leader = substr_replace($this->leader,$this->descriptivecatalogform,18,1);
        $this->leader = substr_replace($this->leader,$this->multipartresourcerecord,19,1);
        $this->leader = substr_replace($this->leader,'4500',20,4);
        
        
        return $this->leader;
        
        
    }
		
	public function setAttributes($values)
    {
        $this->att=$values;
        if(!is_array($values))
            return;
        //$attributes=array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
        foreach($values as $name=>$value)
        {
            $this->$name=$value;
        
        }
    }
	
}
?>
