<?php

/**
 * This is the model class for table "catalog_format".
 *
 * @package application.models
 * @name CatalogFormat
 *
 */
class CatalogFormat extends BaseCatalogFormat
{
    const FORMAT_UNKNOWN=0;
    const FORMAT_BOOK=1;
    const FORMAT_ATLAS=2;
    const FORMAT_MAP=3;
    const FORMAT_TAPECARTRIDGE=4;
    const FORMAT_CHIPCARTRIDGE=5;
    const FORMAT_DISCCARTRIDGE=6;
    const FORMAT_TAPECASSETTE=7;
    const FORMAT_TAPEREEL=8;
    const FORMAT_FLOPPYDISK=9;
    const FORMAT_CDROM=10;
    const FORMAT_SOFTWARE=11;
    const FORMAT_GLOBE=12;
    const FORMAT_BRAILLE=13;
    const FORMAT_FILMSTRIP=14;
    const FORMAT_TRANSPARENCY=15;
    const FORMAT_SLIDE=16;
    const FORMAT_MICROFILM=17;
    const FORMAT_COLLAGE=18;
    const FORMAT_DRAWING=19;
    const FORMAT_PAINTING=20;
    const FORMAT_PRINT=21;
    const FORMAT_PHOTONEGATIVE=22;
    const FORMAT_FLASHCARD=23;
    const FORMAT_CHART=24;
    const FORMAT_PHOTO=25;
    const FORMAT_VIDEOCASSETTE=26;
    const FORMAT_MOTIONPICTURE=27;
    const FORMAT_KIT=28;
    const FORMAT_MUSICALSCORE=29;
    const FORMAT_SENSORIMAGE=30;
    const FORMAT_SOUNDDISC=31;
    const FORMAT_SOUNDCASSETTE=32;
    const FORMAT_SOUNDRECORDING=33;
    const FORMAT_VIDEOCARTRIDGE=34;
    const FORMAT_VIDEODISC=35;
    const FORMAT_VIDEOREEL=36;
    const FORMAT_VIDEO=37;
    const FORMAT_MUSICRECORDING=42;
    const FORMAT_ELECTRONIC=44;
    const FORMAT_PHYSICALOBJECT=45;
    const FORMAT_MANUSCRIPT=46;
    const FORMAT_EBOOK=47;
    const FORMAT_NEWSPAPER=48;
    const FORMAT_JOURNAL=49;
    const FORMAT_SERIAL=50;
    
    
    /**
	 * Returns the static model of the specified AR class.
	 * @return CatalogFormat the static model class
	 */
     
     
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}    
}
