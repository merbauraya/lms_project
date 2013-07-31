<?php
/**
 *  File - MarcLeaderParser 
 *  Purpose - Parse marc leader data
 * 
 * 
 * 
 */
require_once('File/MARC.php');
class MarcLeaderParser
{
    private $leader;
    private $marc;
    const LEADER_LEN=24;
    function __construct($marc)
    {
        $this->marc = $marc;
        $this->leader = $this->marc->getLeader();
        if (strlen($this->leader) != self::LEADER_LEN)
            throw new Exception('Invalid leader length');
        
    }
    /**
     * Get record format. 
     * This function is based on vufind marc import for format field into solr
     * 
     * return integer based on CatalogFormat FORMAT_XX
     */ 
    public function getFormat()
    {
        
        $fixedField = $this->marc->getField('008');
        $formatCode = ' ';
        $marcAr = MarcActiveRecord::setMarc($this->marc);
        (string) $dataField = $this->marc->getField('245');
        
        if (stristr($dataField,'[electronic resource]'))
            return CatalogFormat::FORMAT_ELECTRONIC;
        
        $fields = $this->marc->getFields('007');
        if ($fields)
        {
            foreach ($fields as $field)
            {
                $data = $field->getData();
                $formatCode = strtoupper(strlen($data) >0 ? $data{0} : ' ');
                $formatCode2 = strtoupper(strlen($data > 0) ? $data{1} : ' ');
                switch (strtoupper($formatCode))
                {
                    case 'A':
                        switch ($formatCode2)
                        {
                            case 'D':
                                return CatalogFormat::FORMAT_ATLAS;
                                break;
                            default:
                                return CatalogFormat::FORMAT_MAP;
                            
                        }
                        break;
                    
                    case 'C':
                        switch ($formatCode2)
                        {
                            case 'A':
                                return CatalogFormat::FORMAT_TAPECARTRIDGE;
                                break;
                            case 'B':
                                return CatalogFormat::FORMAT_CHIPCARTRIDGE;
                                break;
                            case 'C':
                                return CatalogFormat::FORMAT_DISCCARTRIDGE;
                                break;
                            case 'F':
                                return CatalogFormat::FORMAT_TAPECASSETTE;
                                break;
                            case 'H':
                                return CatalogFormat::FORMAT_TAPEREEL;
                                break;
                            case 'J':
                                return CatalogFormat::FORMAT_FLOPPYDISK;
                                break;
                            case 'M':
                            case 'O':
                                return CatalogFormat::FORMAT_CDROM;
                                break;
                            case 'R':
                                break;
                            default:
                                return CatalogFormat::FORMAT_SOFTWARE;
                                break;
                        } //case C
                        break;
                    case 'D':
                        return CatalogFormat::FORMAT_GLOBE;
                        break;
                    case 'F':
                        return CatalogFormat::FORMAT_BRAILLE;
                        break;
                    case 'G':
                        switch ($formatCode2)
                        {
                            case 'C':
                            case 'D':
                                return CatalogFormat::FORMAT_FILMSTRIP;
                                break;
                            case 'T':
                                return CatalogFormat::FORMAT_TRANSPARENCY;
                                break;
                            default:
                                return CatalogFormat::FORMAT_SLIDE;
                                break;
                        }
                        break;
                    case 'H':
                        return CatalogFormat::FORMAT_MICROFILM;
                        break;
                    case 'K':
                        switch ($formatCode2)
                        {
                            case 'C':
                                return CatalogFormat::FORMAT_COLLAGE;
                                break;
                            case 'D':
                                return CatalogFormat::FORMAT_DRAWING;
                                break;
                            case 'E':
                                return CatalogFormat::FORMAT_PAINTING;
                                break;
                            case 'F':
                                return CatalogFormat::FORMAT_PRINT;
                                break;
                            case 'G':
                                return CatalogFormat::FORMAT_PHOTONEGATIVE;
                                break;
                            case 'J':
                                return CatalogFormat::FORMAT_PRINT;
                                break;
                            case 'L':
                                return CatalogFormat::FORMAT_DRAWING;
                                break;
                            case 'O':
                                return CatalogFormat::FORMAT_FLASHCARD;
                                break;
                            case 'N':
                                return CatalogFormat::FORMAT_CHART;
                                break;
                            default:
                                return CatalogFormat::FORMAT_PHOTO;
                                break;
                        }
                        break;
                    case 'M':
                        switch ($formatCode2)
                        {
                            case 'F':
                                return CatalogFormat::FORMAT_VIDEOCASSETTE;
                                break;
                            case 'R':
                                return CatalogFormat::FORMAT_FILMSTRIP;
                                break;
                            default:
                                return CatalogFormat::FORMAT_MOTIONPICTURE;
                                break;
                            
                        }
                        break;
                    case 'O':
                        return CatalogFormat::FORMAT_KIT;
                        break;
                    case 'Q':
                        return CatalogFormat::FORMAT_MUSICALSCORE;
                        break;
                    case 'R':
                        return CatalogFormat::FORMAT_SENSORIMAGE;
                        break;
                    case 'S':
                        switch ($formatCode2)
                        {
                            case 'D':
                                return CatalogFormat::FORMAT_SOUNDDISC;
                                break;
                            case 'S':
                                return CatalogFormat::FORMAT_SOUNDCASSETTE;
                                break;
                            default:
                                return CatalogFormat::FORMAT_SOUNDRECORDING;
                                break;
                        }
                        break;
                    
                    case 'V':
                        switch ($formatCode2)
                        {
                            case 'C':
                                return CatalogFormat::FORMAT_VIDEOCARTRIDGE;
                                break;
                            case 'D':
                                return CatalogFormat::FORMAT_VIDEODISC;
                                break;
                            case 'F':
                                return CatalogFormat::FORMAT_VIDEOCASSETTE;
                                break;
                            case 'R':
                                return CatalogFormat::FORMAT_VIDEOREEL;
                                break;
                            default:
                                return CatalogFormat::FORMAT_VIDEO;
                                break;
                        }
                        break;
                    
                }
            }
        }
    
        
        // check the Leader at position 6
        $leaderBit = $this->leader{6};
        switch (strtoupper($leaderBit))
        {
            case 'C':
            case 'D':
                return CatalogFormat::FORMAT_MUSICALSCORE;
                break;
            case 'E':
            case 'F':
                return CatalogFormat::FORMAT_MAP;
                break;
            case 'G':
                return CatalogFormat::FORMAT_SLIDE;
                break;
            case 'I':
                return CatalogFormat::FORMAT_SOUNDRECORDING;
                break;
            case 'J':
                return CatalogFormat::FORMAT_MUSICRECORDING;
                break;
            case 'K':
                return CatalogFormat::FORMAT_PHOTO;
                break;
            case 'M':
                return CatalogFormat::FORMAT_ELECTRONIC;
                break;
            case 'O':
            case 'P':
                return CatalogFormat::FORMAT_KIT;
                break;
            case 'R':
                return CatalogFormat::FORMAT_PHYSICALOBJECT;
                break;
            case 'T':
                return CatalogFormat::FORMAT_MANUSCRIPT;
                break;
            
        }// end check the Leader at position 6
        
        // check the Leader at position 7
        $leaderBit = $this->leader{7};
        
        switch (strtoupper($leaderBit))
        {
            case 'M': //monograph
                $code = $fixedField->getData();
                $formatCode = strtoupper( $code ? $code{23}: ' ');
                switch ($formatCode)
                {
                    case 'O':
                    case 'S':
                        return CatalogFormat::FORMAT_EBOOK;
                        break;
                    default:
                        return CatalogFormat::FORMAT_BOOK;
                        break;
                }
                break;
            case 'S': //serial
                $code = $fixedField->getData();
                $formatCode = $code{21};
                switch (strtoupper($formatCode))
                {
                    case 'N':
                        return CatalogFormat::FORMAT_NEWSPAPER;
                        break;
                    case 'P':
                        return CatalogFormat::FORMAT_JOURNAL;
                        break;
                    default:
                        return CatalogFormat::FORMAT_SERIAL;
                        break;
                    
                }
                break;
        }
        //nothing match
        return CatalogFormat::FORMAT_UNKNOWN;
        
    }
    /*
     * Parse leader and return bibliographic level
     * 
     * 
     */ 
    public function getBibliographicLevel()
    {
        
        $leader = $this->marc->getLeader();
        $bibLevel = $leader{7};
        if ($bibLevel)
            return $bibLevel;
        else
            return '';
        
        
    }


}


?>
