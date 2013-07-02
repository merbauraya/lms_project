<?php
class MarcRecord
{
	protected $marc;
	private $leader;
	
	//title
	private $title_245a;
	private $title_245b;
	private $title_245c;
	
	private $edition_250a;
	//main entry - me
	private $me_PersonalName_100a;
	private $me_CorporateName_110a;
	private $me_MeetingName_111a;
	private $me_UniformTitle_130a;
	
	//publication
	private $publish_place_260a;
	private $publish_publisher_260b;
	private $publish_publish_date_260c;
	
	//physical description
	private $phy_desc_300a;
	private $phy_desc_300b;
	private $phy_desc_300c;
	
	//isbn_issn
	private $isbn_020a;
	private $issn_022a;
	
	//subject
	//private $topical_term_650;
	private $topical_term_650 = array();
	
	
	//notes
	private $note_504a;
	
	//LC Classification
	private $lc_050a;
	
	
	//Dewey Decimal Classification Number
	private $dewey_082;
	
	//geographic area code
	private $geog_043;
	
	//end vars desclaration
	
	function __construct($marcObject)
	{
		$this->marc = $marcObject;
		/*if (!($marcObject instanceof File_MARC_Record))
			print_r($marcObject);
		else
			echo 'marc!';*/
		$this->parse();
	}
	private function parse()
	{
		
		if (method_exists($this->marc,'next'))
			$marc_record = $this->marc->next();	
		else
			$marc_record = $this->marc;
		if (!($marc_record instanceof File_MARC_Record))
		{
			
			exit;
		}
			
		//var_dump($marc_record instanceof File_MARC_Record);
		//while ($marc_record = $this->marc->next()) 
		//{
			$this->leader = $marc_record->getLeader();
			//$fields = $marc_record->getFields();
			//title
			$titleTag = $marc_record->getField('245');
			$titleTag_a = $titleTag->getSubFields('a');
			$this->title_245a = $titleTag_a[0]->getData();
			$_245b = $titleTag->getSubFields('b');
			
			if (isset($_245b[0]))
			{
				$this->title_245b =$_245b[0]->getData();
			}
				//sor
			$sor = $titleTag->getSubFields('c');
			if (isset($sor[0]))
			{
				$this->title_245c = $sor[0]->getData();
			}
			//main entry
			$_100 = $marc_record->getField('100');
			if ($_100)
			{
				$_100a = $_100->getSubFields('a');
				if (isset($_100a[0]))
				{
					$this->me_PersonalName_100a = $_100a[0]->getData();
				}
				
			}//end main entry	
			//edition
			$_250 = $marc_record->getField('250');
			if ($_250)
			{
				$_250a = $_250->getSubFields('a');
				if (isset($_250a[0]))
				{
					$this->edition_250a = $_250a[0]->getData();
				}
			}//end edition
			//publication
			$_260 = $marc_record->getField('260');
			if ($_260)
			{
				$_260a = $_260->getSubFields('a');
				if (isset($_260a[0]))
					$this->publish_place_260a = $_260a[0]->getData();
				$_260b = $_260->getSubFields('b');
				$this->publish_publisher_260b = (isset($_260b[0])? $_260b[0]->getData() :''); 
				$_260c = $_260->getSubFields('c');
				$this->publish_publish_date_260c = (isset($_260c[0])? $_260c[0]->getData() : '');	
				
					
			}//end publication		
			//physical description
			$_300 = $marc_record->getField('300');
			if ($_300)
			{
				$_300a = $_300->getSubFields('a');
				$this->phy_desc_300a = (isset($_300a[0])? $_300a[0]->getData() : '');
				$_300b = $_300->getSubFields('b');
				$this->phy_desc_300b = (isset($_300b[0])? $_300b[0]->getData() : '');
				$_300c = $_300->getSubFields('c');
				$this->phy_desc_300b = (isset($_300c[0])? $_300c[0]->getData() : '');
			} // end physical description
			
			//isbn
			$_020 = $marc_record->getField('020');
			if ($_020)
			{
				foreach ($_020->getSubFields() as $subField)
				{
					$this->isbn_020a .= $subField->getData() .',';
					//echo $subField->getCode();
				}
				
			} //end isbn
			//issn
			
			$_022 = $marc_record->getField('022');
			if ($_022)
			{
				foreach ($_022->getSubFields() as $subField)
				{
					$this->issn_022a .= $subField->getData() .',';
					//echo $subField->getCode();
				}
				
			} //end issn
			//topical term
			$_650 = $marc_record->getField('650');
			if ($_650)
			{
				foreach ($_650->getSubFields() as $subField)
				{
					$this->topical_term_650[$subField->getCode()] = $subField->getData();
					//echo $subField->getCode();
				}
				
			} //end topical term
			
			//notes
			$_504 = $marc_record->getField('504');
			if ($_504)
			{
				$_504a = $_504->getSubFields('a');
				$this->note_504a = (isset($_504a[0]) ? $_504a[0]->getData(): '');
			}//end notes
			
			//lc classification
			$_050 = $marc_record->getField('050');
			if ($_050)
			{
				$_050a = $_050->getSubFields('a');
				$this->lc_050a = (isset($_050a[0]) ? $_050a[0]->getData(): '');
				$_050b = $_050->getSubFields('b');
				$this->lc_050a .=(isset($_050b[0]) ? $_050b[0]->getData(): '');
			}//end lc classification
			//dewey classification
			$_082 = $marc_record->getField('082');
			if ($_082)
			{
				$_082a = $_082->getSubFields('a');
				$this->dewey_082=(isset($_082a[0]) ? $_082a[0]->getData(): '');	
				$_082b = $_082->getSubFields('b');
				$this->dewey_082.=(isset($_082b[0]) ? $_082b[0]->getData(): '');	
			}//end dewey classification
			
			//geography area
			$_043 = $marc_record->getField('043');
			if ($_043)
			{
				$_043a = $_043->getSubFields('a');
				$this->geog_043 =(isset($_043a[0]) ? $_043a[0]->getData(): '');	
				$_043b = $_043->getSubFields('b');
				$this->geog_043.=(isset($_043b[0]) ? $_043b[0]->getData(): '');	
			}
			
		//}
	}
	public function getGeographyAreaCode()
	{
		return $this->geog_043;
	}
	public function getDeweyClassification()
	{
		return $this->dewey_082;
	}
	public function getLCClassification()
	{
		return $this->lc_050a;
	}
	public function getNote()
	{
		return $this->note_504a;
	}
	public function getTopicalTerm()
	{
		return $this->topical_term_650;
	}
	public function getISBN()
	{
		return $this->isbn_020a;
	}
	public function getPhysicalInfo()
	{
		return $this->phy_desc_300a.$this->phy_desc_300b.$this->phy_desc_300c;
	}
	public function getPublicationInfo()
	{
		return $this->publish_place_260a.$this->publish_publisher_260b.$this->publish_publish_date_260c;
	}
	public function getPublicationPlace()
	{
		return $this->publish_place_260a;
	}
	public function getEdition()
	{
		return $this->edition_250a;
	}
	public function get245a()
	{
		return $this->title_245a;
		
	}	
	public function get245b()
	{
		return $title_245b;
	}
	public function get245c()
	{
		return $title_245c;
	}
	public function getFullTitle()
	{
		return $this->title_245a.$this->title_245b.$this->title_245c;
	}
	public function getPersonalName()
	{
		return $this->me_PersonalName_100a;
	}
}
?>