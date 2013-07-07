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
	
	public static function tag($tag)
    {
        if(!isset(self::$_items[$tag]))
            self::loadItems();
        return isset(self::$_items[$tag]) ? self::$_items[$tag] : false;
    }
	
	private static function loadItems()
    {
        self::$_items[]=array();
        $models=self::model()->findAll();
        foreach($models as $model)
		{
			
		   self::$_items[$model->tag]=array(
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
	public static function subfield($tag,$subfield)
	{
		if(!isset(self::$_subfields[$tag][$subfield]))
            self::loadSubfield($tag);
        return isset(self::$_subfields[$tag][$subfield]) ? self::$_subfields[$tag][$subfield] : false;
	
	}
	private static function loadSubfield($tag)
	{
		self::$_subfields[]=array();
        $models=MarcSubfield::model()->findAll(array(
            'condition'=>'tag=:tag',
            'params'=>array(':tag'=>$tag),
             'order'=>'tag,subfield',
        ));
        foreach($models as $model)
		{
			
			self::$_subfields[$model->tag][$model->subfield]=array(
				
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
