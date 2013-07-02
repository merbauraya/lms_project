<?php

class MarcTag
{
	private static $marcTagKeyValue = array('000' =>
	array('Leader', 'NR'), '001' =>
	array('Control Number ', 'NA'), '003' =>
	array('Control Number Identifier ', 'NA'), '005' =>
	array('Date and Time of Latest Transaction ', 'NA'), '006' =>
	array('Fixed-Length Data Elements - Additional Material Characteristics ', 'NA'), '007' =>
	array('Physical Description Fixed Field ', 'NA'), '008' =>
	array('Fixed-Length Data Elements ', 'NA'), '010' =>
	array('Library of Congress Control Number ', 'NR'), '013' =>
	array('Patent Control Information ', 'R'), '015' =>
	array('National Bibliography Number ', 'R'), '016' =>
	array('National Bibliographic Agency Control Number ', 'R'), '017' =>
	array('Copyright or Legal Deposit Number ', 'R'), '018' =>
	array('Copyright Article-Fee Code ', 'NR'), '020' =>
	array('International Standard Book Number ', 'R'), '022' =>
	array('International Standard Serial Number ', 'R'), '024' =>
	array('Other Standard Identifier ', 'R'), '025' =>
	array('Overseas Acquisition Number ', 'R'), '026' =>
	array('Fingerprint Identifier ', 'R'), '027' =>
	array('Standard Technical Report Number ', 'R'), '028' =>
	array('Publisher Number ', 'R'), '030' =>
	array('CODEN Designation ', 'R'), '031' =>
	array('Musical Incipits Information ', 'R'), '032' =>
	array('Postal Registration Number ', 'R'), '033' =>
	array('Date/Time and Place of an Event ', 'R'), '034' =>
	array('Coded Cartographic Mathematical Data ', 'R'), '035' =>
	array('System Control Number ', 'R'), '036' =>
	array('Original Study Number for Computer Data Files ', 'NR'), '037' =>
	array('Source of Acquisition ', 'R'), '038' =>
	array('Record Content Licensor ', 'NR'), '040' =>
	array('Cataloging Source ', 'NR'), '041' =>
	array('Language Code ', 'R'), '042' =>
	array('Authentication Code ', 'NR'), '043' =>
	array('Geographic Area Code ', 'NR'), '044' =>
	array('Country of Publishing/Producing Entity Code ', 'NR'), '045' =>
	array('Time Period of Content ', 'NR'), '046' =>
	array('Special Coded Dates ', 'R'), '047' =>
	array('Form of Musical Composition Code ', 'NR'), '048' =>
	array('Number of Musical Instruments or Voices Codes ', 'R'), '050' =>
	array('Library of Congress Call Number ', 'R'), '051' =>
	array('Library of Congress Copy, Issue, Offprint Statement ', 'R'), '052' =>
	array('Geographic Classification ', 'R'), '055' =>
	array('Classification Numbers Assigned in Canada ', 'R'), '060' =>
	array('National Library of Medicine Call Number ', 'R'), '061' =>
	array('National Library of Medicine Copy Statement ', 'R'), '066' =>
	array('Character Sets Present ', 'NR'), '070' =>
	array('National Agricultural Library Call Number ', 'R'), '071' =>
	array('National Agricultural Library Copy Statement ', 'R'), '072' =>
	array('Subject Category Code ', 'R'), '074' =>
	array('GPO Item Number ', 'R'), '080' =>
	array('Universal Decimal Classification Number ', 'R'), '082' =>
	array('Dewey Decimal Classification Number ', 'R'), '083' =>
	array('Additional Dewey Decimal Classification Number ', 'R'), '084' =>
	array('Other Classification Number ', 'R'), '085' =>
	array('Synthesized Classification Number Components ', 'R'), '086' =>
	array('Government Document Classification Number ', 'R'), '088' =>
	array('Report Number ', 'R'), '09X' =>
	array('Local Call Numbers ', 'NR'), '100' =>
	array('Main Entry - Personal Name ', 'NR'), '110' =>
	array('Main Entry - Corporate Name ', 'NR'), '111' =>
	array('Main Entry - Meeting Name ', 'NR'), '130' =>
	array('Main Entry - Uniform Title ', 'NR'), '210' =>
	array('Abbreviated Title ', 'R'), '222' =>
	array('Key Title ', 'R'), '240' =>
	array('Uniform Title ', 'NR'), '242' =>
	array('Translation of Title by Cataloging Agency ', 'R'), '243' =>
	array('Collective Uniform Title ', 'NR'), '245' =>
	array('Title Statement ', 'NR'), '246' =>
	array('Varying Form of Title ', 'R'), '247' =>
	array('Former Title ', 'R'), '250' =>
	array('Edition Statement ', 'NR'), '254' =>
	array('Musical Presentation Statement ', 'NR'), '255' =>
	array('Cartographic Mathematical Data ', 'R'), '256' =>
	array('Computer File Characteristics ', 'NR'), '257' =>
	array('Country of Producing Entity ', 'R'), '258' =>
	array('Philatelic Issue Data ', 'R'), '260' =>
	array('Publication, Distribution, etc. (Imprint) ', 'R'), '263' =>
	array('Projected Publication Date ', 'NR'), '264' =>
	array('Production, Publication, Distribution, Manufacture, and Copyright Notice ', 'R'), '270' =>
	array('Address ', 'R'), '300' =>
	array('Physical Description ', 'R'), '306' =>
	array('Playing Time ', 'NR'), '307' =>
	array('Hours, etc. ', 'R'), '310' =>
	array('Current Publication Frequency ', 'NR'), '321' =>
	array('Former Publication Frequency ', 'R'), '336' =>
	array('Content Type ', 'R'), '337' =>
	array('Media Type ', 'R'), '338' =>
	array('Carrier Type ', 'R'), '340' =>
	array('Physical Medium ', 'R'), '342' =>
	array('Geospatial Reference Data ', 'R'), '343' =>
	array('Planar Coordinate Data ', 'R'), '344' =>
	array('Sound Characteristics ', 'R'), '345' =>
	array('Projection Characteristics of Moving Image ', 'R'), '346' =>
	array('Video Characteristics ', 'R'), '347' =>
	array('Digital File Characteristics ', 'R'), '351' =>
	array('Organization and Arrangement of Materials ', 'R'), '352' =>
	array('Digital Graphic Representation ', 'R'), '355' =>
	array('Security Classification Control ', 'R'), '357' =>
	array('Originator Dissemination Control ', 'NR'), '362' =>
	array('Dates of Publication and/or Sequential Designation ', 'R'), '363' =>
	array('Normalized Date and Sequential Designation ', 'R'), '365' =>
	array('Trade Price ', 'R'), '366' =>
	array('Trade Availability Information ', 'R'), '377' =>
	array('Associated Language ', 'R'), '380' =>
	array('Form of Work ', 'R'), '381' =>
	array('Other Distinguishing Characteristics of Work or Expression ', 'R'), '382' =>
	array('Medium of Performance ', 'R'), '383' =>
	array('Numeric Designation of Musical Work ', 'R'), '384' =>
	array('Key ', 'NR'), '490' =>
	array('Series Statement ', 'R'), '500' =>
	array('General Note ', 'R'), '501' =>
	array('With Note ', 'R'), '502' =>
	array('Dissertation Note ', 'R'), '504' =>
	array('Bibliography, etc. Note ', 'R'), '505' =>
	array('Formatted Contents Note ', 'R'), '506' =>
	array('Restrictions on Access Note ', 'R'), '507' =>
	array('Scale Note for Graphic Material ', 'NR'), '508' =>
	array('Creation/Production Credits Note ', 'R'), '510' =>
	array('Citation/References Note ', 'R'), '511' =>
	array('Participant or Performer Note ', 'R'), '513' =>
	array('Type of Report and Period Covered Note ', 'R'), '514' =>
	array('Data Quality Note ', 'NR'), '515' =>
	array('Numbering Peculiarities Note ', 'R'), '516' =>
	array('Type of Computer File or Data Note ', 'R'), '518' =>
	array('Date/Time and Place of an Event Note ', 'R'), '520' =>
	array('Summary, etc. ', 'R'), '521' =>
	array('Target Audience Note ', 'R'), '522' =>
	array('Geographic Coverage Note ', 'R'), '524' =>
	array('Preferred Citation of Described Materials Note ', 'R'), '525' =>
	array('Supplement Note ', 'R'), '526' =>
	array('Study Program Information Note ', 'R'), '530' =>
	array('Additional Physical Form available Note ', 'R'), '533' =>
	array('Reproduction Note ', 'R'), '534' =>
	array('Original Version Note ', 'R'), '535' =>
	array('Location of Originals/Duplicates Note ', 'R'), '536' =>
	array('Funding Information Note ', 'R'), '538' =>
	array('System Details Note ', 'R'), '540' =>
	array('Terms Governing Use and Reproduction Note ', 'R'), '541' =>
	array('Immediate Source of Acquisition Note ', 'R'), '542' =>
	array('Information Relating to Copyright Status ', 'R'), '544' =>
	array('Location of Other Archival Materials Note ', 'R'), '545' =>
	array('Biographical or Historical Data ', 'R'), '546' =>
	array('Language Note ', 'R'), '547' =>
	array('Former Title Complexity Note ', 'R'), '550' =>
	array('Issuing Body Note ', 'R'), '552' =>
	array('Entity and Attribute Information Note ', 'R'), '555' =>
	array('Cumulative Index/Finding Aids Note ', 'R'), '556' =>
	array('Information About Documentation Note ', 'R'), '561' =>
	array('Ownership and Custodial History ', 'R'), '562' =>
	array('Copy and Version Identification Note ', 'R'), '563' =>
	array('Binding Information ', 'R'), '565' =>
	array('Case File Characteristics Note ', 'R'), '567' =>
	array('Methodology Note ', 'R'), '580' =>
	array('Linking Entry Complexity Note ', 'R'), '581' =>
	array('Publications About Described Materials Note ', 'R'), '583' =>
	array('Action Note ', 'R'), '584' =>
	array('Accumulation and Frequency of Use Note ', 'R'), '585' =>
	array('Exhibitions Note ', 'R'), '586' =>
	array('Awards Note ', 'R'), '588' =>
	array('Source of Description Note ', 'R'), '59X' =>
	array('Local Notes ', 'NR'), '600' =>
	array('Subject Added Entry - Personal Name ', 'R'), '610' =>
	array('Subject Added Entry - Corporate Name ', 'R'), '611' =>
	array('Subject Added Entry - Meeting Name ', 'R'), '630' =>
	array('Subject Added Entry - Uniform Title ', 'R'), '648' =>
	array('Subject Added Entry - Chronological Term ', 'R'), '650' =>
	array('Subject Added Entry - Topical Term ', 'R'), '651' =>
	array('Subject Added Entry - Geographic Name ', 'R'), '653' =>
	array('Index Term - Uncontrolled ', 'R'), '654' =>
	array('Subject Added Entry - Faceted Topical Terms ', 'R'), '655' =>
	array('Index Term - Genre/Form ', 'R'), '656' =>
	array('Index Term - Occupation ', 'R'), '657' =>
	array('Index Term - Function ', 'R'), '658' =>
	array('Index Term - Curriculum Objective ', 'R'), '662' =>
	array('Subject Added Entry - Hierarchical Place Name ', 'R'), '69X' =>
	array('Local Subject Access Fields ', 'R'), '700' =>
	array('Added Entry - Personal Name ', 'R'), '710' =>
	array('Added Entry - Corporate Name ', 'R'), '711' =>
	array('Added Entry - Meeting Name ', 'R'), '720' =>
	array('Added Entry - Uncontrolled Name ', 'R'), '730' =>
	array('Added Entry - Uniform Title ', 'R'), '740' =>
	array('Added Entry - Uncontrolled Related/Analytical Title ', 'R'), '751' =>
	array('Added Entry - Geographic Name ', 'R'), '752' =>
	array('Added Entry - Hierarchical Place Name ', 'R'), '753' =>
	array('System Details Access to Computer Files ', 'R'), '754' =>
	array('Added Entry - Taxonomic Identification ', 'R'), '760' =>
	array('Main Series Entry ', 'R'), '762' =>
	array('Subseries Entry ', 'R'), '765' =>
	array('Original Language Entry ', 'R'), '767' =>
	array('Translation Entry ', 'R'), '770' =>
	array('Supplement/Special Issue Entry ', 'R'), '772' =>
	array('Supplement Parent Entry ', 'R'), '773' =>
	array('Host Item Entry ', 'R'), '774' =>
	array('Constituent Unit Entry ', 'R'), '775' =>
	array('Other Edition Entry ', 'R'), '776' =>
	array('Additional Physical Form Entry ', 'R'), '777' =>
	array('Issued With Entry ', 'R'), '780' =>
	array('Preceding Entry ', 'R'), '785' =>
	array('Succeeding Entry ', 'R'), '786' =>
	array('Data Source Entry ', 'R'), '787' =>
	array('Other Relationship Entry ', 'R'), '800' =>
	array('Series Added Entry - Personal Name ', 'R'), '810' =>
	array('Series Added Entry - Corporate Name ', 'R'), '811' =>
	array('Series Added Entry - Meeting Name ', 'R'), '830' =>
	array('Series Added Entry - Uniform Title ', 'R'), '841' =>
	array('Holdings Coded Data Values ', 'NR'), '842' =>
	array('Textual Physical Form Designator ', 'NR'), '843' =>
	array('Reproduction Note ', 'R'), '844' =>
	array('Name of Unit ', 'NR'), '845' =>
	array('Terms Governing Use and Reproduction ', 'R'), '850' =>
	array('Holding Institution ', 'R'), '852' =>
	array('Location ', 'R'), '853' =>
	array('Captions and Pattern - Basic Bibliographic Unit ', 'R'), '854' =>
	array('Captions and Pattern - Supplementary Material ', 'R'), '855' =>
	array('Captions and Pattern - Indexes ', 'R'), '856' =>
	array('Electronic Location and Access ', 'R'), '863' =>
	array('Enumeration and Chronology - Basic Bibliographic Unit ', 'R'), '864' =>
	array('Enumeration and Chronology - Supplementary Material ', 'R'), '865' =>
	array('Enumeration and Chronology - Indexes ', 'R'), '866' =>
	array('Textual Holdings - Basic Bibliographic Unit ', 'R'), '867' =>
	array('Textual Holdings - Supplementary Material ', 'R'), '868' =>
	array('Textual Holdings - Indexes ', 'R'), '876' =>
	array('Item Information - Basic Bibliographic Unit ', 'R'), '877' =>
	array('Item Information - Supplementary Material ', 'R'), '878' =>
	array('Item Information - Indexes ', 'R'), '880' =>
	array('Alternate Graphic Representation ', 'R'), '882' =>
	array('Replacement Record Information ', 'NR'), '883' =>
	array('Machine-generated Metadata Provenance ', 'R'), '886' =>
	array('Foreign MARC Information Field ', 'R'), '887' =>
	array('Non-MARC Information Field ', 'R'));
	
	private static $marcSubField = array(
	'010a'=>array('LC control number ','NR'),

'010b'=>array('NUCMC control number ','R'),

'010z'=>array('Canceled/invalid LC control number ','R'),

'0108'=>array('Field link and sequence number ','R'),
'013a'=>array('Number ','NR'),

'013b'=>array('Country ','NR'),

'013c'=>array('Type of number ','NR'),

'013d'=>array('Date ','R'),

'013e'=>array('Status ','R'),

'013f'=>array('Party to document ','R'),

'0136'=>array('Linkage ','NR'),

'0138'=>array('Field link and sequence number ','R'),
'015a'=>array('National bibliography number ','R'),

'015z'=>array('Canceled/invalid national bibliography number ','R'),

'0152'=>array('Source ','NR'),

'0156'=>array('Linkage ','NR'),

'0158'=>array('Field link and sequence number ','R'),
'016a'=>array('Record control number ','NR'),

'016z'=>array('Canceled/invalid control number ','R'),

'0162'=>array('Source ','NR'),

'0168'=>array('Field link and sequence number ','R'),
'017a'=>array('Copyright or legal deposit number ','R'),

'017b'=>array('Assigning agency ','NR'),

'017d'=>array('Date ','NR'),

'017i'=>array('Display text ','NR'),

'017z'=>array('Canceled/invalid copyright or legal deposit number ','R'),

'0172'=>array('Source ','NR'),

'0176'=>array('Linkage ','NR'),

'0178'=>array('Field link and sequence number ','R'),
'018a'=>array('Copyright articlefee code ','NR'),

'0186'=>array('Linkage ','NR'),

'0188'=>array('Field link and sequence number ','R'),
'020a'=>array('International Standard Book Number ','NR'),

'020c'=>array('Terms of availability ','NR'),

'020z'=>array('Canceled/invalid ISBN ','R'),

'0206'=>array('Linkage ','NR'),

'0208'=>array('Field link and sequence number ','R'),
'022a'=>array('International Standard Serial Number ','NR'),

'022l'=>array('ISSNL ','NR'),

'022m'=>array('Canceled ISSNL ','R'),

'022m'=>array('ISSNL (canceled) may be generated for displa','NR'),

'022y'=>array('Incorrect ISSN ','R'),

'022z'=>array('Canceled ISSN ','R'),

'0222'=>array('Source ','NR'),

'0226'=>array('Linkage ','NR'),

'0228'=>array('Field link and sequence number ','R'),
'024a'=>array('Standard number or code ','NR'),

'024c'=>array('Terms of availability ','NR'),

'024d'=>array('Additional codes following the standard number or code ','NR'),

'024z'=>array('Canceled/invalid standard number or code ','R'),

'0242'=>array('Source of number or code ','NR'),

'0246'=>array('Linkage ','NR'),

'0248'=>array('Field link and sequence number ','R'),
'025a'=>array('Overseas acquisition number ','R'),

'0258'=>array('Field link and sequence number ','R'),
'026a'=>array('First and second groups of characters ','NR'),

'026b'=>array('Third and fourth groups of characters ','NR'),

'026c'=>array('Date ','NR'),

'026d'=>array('Number of volume or part ','R'),

'026e'=>array('Unparsed fingerprint ','NR'),

'0262'=>array('Source ','NR'),

'0265'=>array('Institution to which field applies ','R'),

'0266'=>array('Linkage ','NR'),

'0268'=>array('Field link and sequence number ','R'),
'027a'=>array('Standard technical report number ','NR'),

'027z'=>array('Canceled/invalid number ','R'),

'0276'=>array('Linkage ','NR'),

'0278'=>array('Field link and sequence number ','R'),
'028a'=>array('Publisher number ','NR'),

'028b'=>array('Source ','NR'),

'028q'=>array('Qualifying information ','R'),

'0286'=>array('Linkage ','NR'),

'0288'=>array('Field link and sequence number ','R'),
'030a'=>array('CODEN ','NR'),

'030z'=>array('Canceled/invalid CODEN ','R'),

'0306'=>array('Linkage ','NR'),

'0308'=>array('Field link and sequence number ','R'),
'031a'=>array('Number of work ','NR'),

'031b'=>array('Number of movement ','NR'),

'031c'=>array('Number of excerpt ','NR'),

'031d'=>array('Caption or heading ','R'),

'031e'=>array('Role ','NR'),

'031g'=>array('Clef ','NR'),

'031m'=>array('Voice/instrument ','NR'),

'031n'=>array('Key signature ','NR'),

'031o'=>array('Time signature ','NR'),

'031p'=>array('Musical notation ','NR'),

'031q'=>array('General note ','R'),

'031r'=>array('Key or mode ','NR'),

'031s'=>array('Coded validity note ','R'),

'031t'=>array('Text incipit ','R'),

'031u'=>array('Uniform Resource Identifier ','R'),

'031y'=>array('Link text ','R'),

'031z'=>array('Public note ','R'),

'0312'=>array('System code ','NR'),

'031p'=>array('Musical notation). Use of subfie','NR'),

'0312'=>array('s mandatory if subfie','NR'),

'031p'=>array('s present. Code from: Musical Incipit Scheme Source Code','NR'),

'0316'=>array('Linkage ','NR'),

'0318'=>array('Field link and sequence number ','R'),
'032a'=>array('Postal registration number ','NR'),

'032b'=>array('Source agency assigning number ','NR'),

'0326'=>array('Linkage ','NR'),

'0328'=>array('Field link and sequence number ','R'),
'033a'=>array('Formatted date/time ','R'),

'033b'=>array('Geographic classification area code ','R'),

'033c'=>array('Geographic classification subarea code ','R'),

'033p'=>array('Place of event ','R'),

'0330'=>array('Record control number ','R'),

'0332'=>array('Source of term ','R'),

'033p'=>array('hen it is from a controlled list. Code from: Subject Heading and Term Source Code','NR'),

'0333'=>array('Materials specified ','NR'),

'0336'=>array('Linkage ','NR'),

'0338'=>array('Field link and sequence number ','R'),
'034a'=>array('Category of scale ','NR'),

'034b'=>array('Constant ratio linear horizontal scale ','R'),

'034c'=>array('Constant ratio linear vertical scale ','R'),

'034d'=>array('Coordinates - westernmost longitude ','NR'),

'034e'=>array('Coordinates - easternmost longitude ','NR'),

'034f'=>array('Coordinates - northernmost latitude ','NR'),

'034g'=>array('Coordinates - southernmost latitude ','NR'),

'034h'=>array('Angular scale ','R'),

'034j'=>array('Declination - northern limit ','NR'),

'034k'=>array('Declination - southern limit ','NR'),

'034m'=>array('Right ascension - eastern limit ','NR'),

'034n'=>array('Right ascension - western limit ','NR'),

'034p'=>array('Equinox ','NR'),

'034r'=>array('Distance from earth ','NR'),

'034s'=>array('G-ring latitude ','R'),

'034t'=>array('G-ring longitude ','R'),

'034x'=>array('Beginning date ','NR'),

'034y'=>array('Ending date ','NR'),

'034z'=>array('Name of extraterrestrial body ','NR'),

'0340'=>array('Authority record control number or standard number ','R'),

'0342'=>array('Source ','NR'),

'0343'=>array('Materials specified ','NR'),

'0346'=>array('Linkage ','NR'),

'0348'=>array('Field link and sequence number ','R'),
'035a'=>array('System control number ','NR'),

'035z'=>array('Canceled/invalid control number ','R'),

'0356'=>array('Linkage ','NR'),

'0358'=>array('Field link and sequence number ','R'),
'036a'=>array('Original study number ','NR'),

'036b'=>array('Source agency assigning number ','NR'),

'0366'=>array('Linkage ','NR'),

'0368'=>array('Field link and sequence number ','R'),
'037a'=>array('Stock number ','NR'),

'037b'=>array('Source of stock number/acquisition ','NR'),

'037c'=>array('Terms of availability ','R'),

'037f'=>array('Form of issue ','R'),

'037g'=>array('Additional format characteristics ','R'),

'037n'=>array('Note ','R'),

'0376'=>array('Linkage ','NR'),

'0378'=>array('Field link and sequence number ','R'),
'038a'=>array('Record content licensor ','NR'),

'0386'=>array('Linkage ','NR'),

'0388'=>array('Field link and sequence number ','R'),
'040a'=>array('Original cataloging agency ','NR'),

'040b'=>array('Language of cataloging ','NR'),

'040c'=>array('Transcribing agency ','NR'),

'040d'=>array('Modifying agency ','R'),

'040e'=>array('Description conventions ','R'),

'0406'=>array('Linkage ','NR'),

'0408'=>array('Field link and sequence number ','R'),
'041a'=>array('Language code of text/sound track or separate title ','R'),

'041b'=>array('Language code of summary or abstract ','R'),

'041d'=>array('Language code of sung or spoken text ','R'),

'041e'=>array('Language code of librettos ','R'),

'041f'=>array('Language code of table of contents ','R'),

'041g'=>array('Language code of accompanying material other than librettos ','R'),

'041h'=>array('Language code of original ','R'),

'041j'=>array('Language code of subtitles or captions ','R'),

'041k'=>array('Language code of intermediate translations ','R'),

'041m'=>array('Language code of original accompanying materials other than librettos ','R'),

'041n'=>array('Language code of original libretto ','R'),

'0412'=>array('Source of code ','NR'),

'0416'=>array('Linkage ','NR'),

'0418'=>array('Field link and sequence number ','R'),
'042a'=>array('Authentication code ','R'),
'043a'=>array('Geographic area code ','R'),

'043b'=>array('Local GAC code ','R'),

'043c'=>array('ISO code ','R'),

'0430'=>array('Authority record control number or standard number ','R'),

'0432'=>array('Source of local code ','R'),

'0436'=>array('Linkage ','NR'),

'0438'=>array('Field link and sequence number ','R'));
	
	

	public static function getSubFieldDescription($subField)
	{
		if (array_key_exists($subField,self::$marcSubField))
		{
			return self::$marcSubField[$subField];
		}else
		{
			return array('Description not found','0');
		}
	}

	public static function getTagDescription($marcTag)
	{
		
		if (array_key_exists($marcTag,self::$marcTagKeyValue))
		{
			return self::$marcTagKeyValue[$marcTag];	
		}else
		{
			return array('Description Not Found','0');
		}
		
	}
	public static function getTag()
	{
		return self::$marcTagKeyValue;
	}
	public static function parseMarcData($marc_data)
	{
		$data         = array();
		$tag245       = $record->getField('245');
		$_245a        = $tag245->getSubFields('a');
		$data['245a'] = $_245a[0]->getData();
		return $data;
	}
	public static function getMarc245Data($tag245)
	{
		$_245a = $tag245->getSubFields('a');
		$_245b = $tag245->getSubFields('b');
		$_245c = $tag245->getSubFields('c'); //sor
		return array(
		'a' =>
		$_245a,
		'b' =>
		$_245b,
		'c' =>
		$_245c
		);
	}
}
?>