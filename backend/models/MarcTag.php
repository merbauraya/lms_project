<?php

/**
 * This is the model class for table "marc_tag".
 *
 * @package application.models
 * @name MarcTag
 *
 */
class MarcTag extends BaseMarcTag
{
	private static $_items=array();
	private static $_subfields = array();
	/**
	 * Returns the static model of the specified AR class.
	 * @return MarcTag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function tag($tag,$tagType='BIBLIO')
    {
        if(!isset(self::$_items[$tag][$tagType]))
            self::loadItems($tagType);
        return isset(self::$_items[$tag][$tagType]) ? self::$_items[$tag][$tagType] : false;
    }
	
	private static function loadItems($tagType='BIBLIO')
    {
        self::$_items[]=array();
        $models=self::model()->findAll(array(
						'order'=>'tag', 
						'condition'=>'tag_type= :tagType', 
						'params'=>array(':tagType'=>$tagType))
        );
        foreach($models as $model)
		{
			
		   self::$_items[$model->tag][$tagType]=array(
                'tag'=>$model->tag,
				'name'=>$model->loc_description,
				'help'=>$model->help_text,
				'repeatable'=>$model->repeatable,
				'mandatory'=>$model->mandatory,
				'default_value'=>$model->default_value,
                'indi1'=>$model->indicator1,
                'indi2'=>$model->indicator2,
			
			);
		}
    }
	public static function subfield($tag,$subfield,$tagType='BIBLIO')
	{
		if(!isset(self::$_subfields[$tag][$subfield][$tagType]))
            self::loadSubfield($tag,$tagType);
        return isset(self::$_subfields[$tag][$subfield][$tagType]) ? self::$_subfields[$tag][$subfield][$tagType] : false;
	
	}
	private static function loadSubfield($tag,$tagType='BIBLIO')
	{
		self::$_subfields[]=array();
        $models=MarcSubfield::model()->findAll(array(
            'condition'=>'tag=:tag and tag_type=:tagType',
            'params'=>array(':tag'=>$tag,':tagType'=>$tagType),
            'order'=>'tag,subfield',
        ));
        foreach($models as $model)
		{
			
			self::$_subfields[$model->tag][$model->subfield][$tagType]=array(
				
                'name'=>$model->loc_desc,
				'help'=>$model->help_text,
				'repeatable'=>$model->repeatable,
				'mandatory'=>$model->mandatory,
				'default_value'=>$model->default_value,
				'link'=>$model->link,
				'link_alt_text'=>$model->link_alt_text,
                
			
			);
		}	
	
	}
		
}
