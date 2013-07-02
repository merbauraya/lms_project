<?php
class Z3950_SRU extends LmZ3950
{
	private $_xml;
	private $_doc;
	private $_sru_xml ; //original xml response from the server
	const SCHEMA_MODS = 'mods';
	const SCHEMA_MARCXML = 'marcxml';
	private $_data = array();
	private $_marcXml; //our transformed marcm xml
	private $_Marc; //our marc object
	function __construct($server, $port,$database)
	{
		$this->_server = $server;
		$this->_port = $port;
		$this->_database = $database;
	}
	
	public function query($keyword,$qtype,$schema = self::SCHEMA_MARCXML,$startRecord=1,$maxRecord=20)
	{
		//build query string
		$squery = '?version=1.1&operation=searchRetrieve&startRecord='.$startRecord .'&maximumRecords='.$maxRecord.'&recordSchema='.$schema;
		//construct server url;
		if ($qtype != '0')
			$keyword = urlencode($qtype . '='.$keyword);
		else
			$keyword = urlencode('"'.$keyword.'"');
		
		
		$this->_url = $this->_server. ':'.$this->_port.'/'.$this->_database;
		$this->_url .= $squery.'&query='.$keyword;
		
		$this->_sru_xml = new SimpleXMLElement($this->_url, LIBXML_NSCLEAN, true);
		$this->_recordCount = $this->_sru_xml->children('http://www.loc.gov/zing/srw/')->numberOfRecords;
		//$this->xmlXform2MarcXML();
		
		
		
	}
	public function getURL()
	{
		return $this->_url;
	}
	public function getRawResult()
	{
		return $this->_sru_xml;
	
	}
	public function getDataHeader()
	{
		
		
	}
	/**
	*	Transform the returned xml into MarcXML that is understood by File_Marc
	*
	*/
	public function xmlXform2MarcXML()
	{
		$doc = new DOMDocument();
		$doc->loadXML($this->_sru_xml->asXML());
		$xsl = new DOMDocument;
		$xslpath = realpath(Yii::getPathOfAlias('xsl'));
		$xsl->load($xslpath.DIRECTORY_SEPARATOR.'sruxml2marc.xsl');	
			// Configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attach the xsl rules
		$this->_marcXml= $proc->transformToXML($doc);
		return $this->_marcXml;
		
	}
	public function getRecordCount()
	{
		return $this->_recordCount;
	}	

}
