<?php
class MarcTagRecord

{
	private $_tag;
	private $_indi1;
	private $_indi2;
	private $_subfield;
	private $_data;
	
	public setEntry($tag,$indi1,$indi2,$subfield,$data)
	{
		$this->_tag = $tag;
		$this->_indi1 = $indi1;
		$this->_indi2 = $indi2;
		$this->_subfield = $subField;
		$this->_data = $data;
	}
		
}
?>