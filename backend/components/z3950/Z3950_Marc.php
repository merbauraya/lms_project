<?php
class Z3950_Marc
{
	private $_response; //xmlelement response receive from z3950 server
	private $_marc; //our File_Marc based on the response received
	private $_marc_xml; //our marcXML buffer
	private $_dataHeader = array();
	const RESPONSE_MARCXML=1;
	
	public function setz3950Response($response,$format=self::RESPONSE_MARCXML)
	{
		$this->_response = $response;
		$this->transformToMarcXml();
	}
	/**
	*	Return summary header based on response received
	*
	*
	*/
	public function getDataHeader()
	{
		//if (!empty($this->_dataHeader))
		//	return $this->_dataHeader;
		$this->_marc = new File_MARCXML($this->_marc_xml,File_MARCXML::SOURCE_STRING);
		
		$n = 0;
		while ($m = $this->_marc->next())
		{
			
			$marc_record = new MarcRecord($m);
			//echo $marc_record->get245a();//$marc_record = new MarcRecord($mr);
			$this->_dataHeader[] = array(
				'title'=>$marc_record->get245a(),
				'isbn'=>$marc_record->getISBN(),
			
			);
			//$this->_dataHeader['title'][] = $marc_record->get245a();
			//$this->_dataHeader['isbn'][] = $marc_record->getISBN();
			//$this->_dataHeader['publication'][]=$marc_record->getPublicationInfo();
			
			//todo add author,publication date
			//	echo $n;
						$n++;
		}
		
		return $this->_dataHeader;
	
	}
	private function transformToMarcXml()
	{
		$doc = new DOMDocument();
		$doc->loadXML($this->_response->asXML());
		$xsl = new DOMDocument;
		$xslpath = realpath(Yii::getPathOfAlias('xsl'));
		$xsl->load($xslpath.DIRECTORY_SEPARATOR.'sruxml2marc.xsl');	
			// Configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attach the xsl rules
		$this->_marc_xml= $proc->transformToXML($doc);
		//return $this->_marcXml;
	
	}
	

}