<?php
abstract class MarcBase
{
	//title
	protected $title_245a;
	protected $title_245b;
	protected $title_245c;
	
	protected $edition_250a;
	//main entry - me
	protected $me_PersonalName_100a;
	protected $me_CorporateName_110a;
	protected $me_MeetingName_111a;
	protected $me_UniformTitle_130a;
	
	//publication
	protected $publish_place_260a;
	protected $publish_publisher_260b;
	protected $publish_publish_date_260c;
	
	//physical description
	protected $phy_desc_300a;
	protected $phy_desc_300b;
	protected $phy_desc_300c;
	
	//isbn_issn
	protected $isbn_020a;
	protected $issn_022a;
	
	abstract public function getData($tag,$subField);
}
?>