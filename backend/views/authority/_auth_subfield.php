<?php
    
    $buffer = CHtml::tag('div',array(
				'id'=>$tag.'-'.$counter.'-subfield',
				'class'=>'row-fluid marc-subfield'),'',false
		); //main row
	
    
    foreach ($subfields as $subfield)
    {
        //start our subfield row
        $buffer .= CHtml::tag('div',array(
                    'id'=>$tag .'-'. $subfield->subfield.'-'.$counter,
                    'class'=>'row-fluid marc-subfield'),'',false
		);
        
        $buffer .=CHtml::tag('span',array('style'=>'padding-left:10px;'),'',false);
        $buffer .='['.$subfield->subfield .'] ' . $subfield->loc_description;
        $buffer .='&nbsp;'. generateLink('Delete Subfield','delete-subfield','icon-remove');
        $buffer .=CHtml::closeTag('span'); //subfield
        $buffer .=CHtml::closeTag('div'); //subfield
    }
    
    $buffer .=CHtml::closeTag('div'); //main row
    
    echo $buffer;
    function generateLink($title,$class,$icon='icon-edit',$click=null)
	{
		$buffer = '';
		$linkIcon = CHtml::tag('i',array(
			'class'=>$icon
			)
		);
		
		$buffer = CHtml::link($linkIcon,'#',array(
			'title'=>$title,
			'class'=>$class,
			'onClick'=>$click,
		)	);
		return $buffer;
		
	}

?>
<script type="text/javascript">
    $(".delete-subfield").live('click',function()
	{
    
    
    }

</script>
