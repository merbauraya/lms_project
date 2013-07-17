<?php
/**
 * This will render list of subfield for a given template and tag
 * 
 * 
 * 
 */


?>

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
        $linkId = $tag.'-'.$subfield->subfield.'-id'.$counter;
        $buffer .=CHtml::tag('span',array('style'=>'padding-left:10px;'),'',false);
        $buffer .='['.$subfield->subfield .'] ' . $subfield->loc_description;
        $buffer .='&nbsp;'. generateLink('Delete Subfield','delete-subfield','icon-remove',null,$linkId);
        $buffer .=CHtml::closeTag('span'); //subfield
        $buffer .=CHtml::closeTag('div'); //subfield
    }
    
    $buffer .=CHtml::closeTag('div'); //main row
    
    echo $buffer;
    function generateLink($title,$class,$icon='icon-edit',$click=null,$id)
	{
		$buffer = '';
		$linkIcon = CHtml::tag('i',array(
			'class'=>$icon
			)
		);
		
		$buffer = CHtml::link($linkIcon,'#',array(
			'title'=>$title,
			'class'=>$class,
            'id'=>$id,
            'rel'=>'tooltip',
			'onClick'=>$click,
		)	);
		return $buffer;
		
	}

?>
<?php
Yii::app()->clientScript->registerScript('delete_subfield',"
    window.deleteSubfield = window.deleteSubfield || {};
    if (!window.deleteSubfield.liveClickHandlerAttached) {
        window.deleteSubfield.liveClickHandlerAttached = true;

        $('.delete-subfield').live('click',function(event)
        {
    
            //get parent id
            event.preventDefault();
            var parentID = $(this).parent().closest('div[id]').attr('id');
            //console.log(parentID);
            
            //get tag and subfield from parentid :id format=tag-subfield-counter
            var arrID = parentID.split('-');
            var authTag = arrID[0];
            var authSubfield = arrID[1];
            var templateID = $('#authorityTemplate').val();
            {jQuery.ajax(
                {
                    type:'POST',
                    data: {tag: authTag,subfield: authSubfield,authType:templateID},
                    url:'/authority/deletesubfield/',
                    cache:false,
                    dataType: 'json',
                    success:function(data)
                    {
                        $.lmNotify(data);
                        $('#' + parentID).remove();
                    },
                    error : function(data)
                    {
                        $.lmNotify(data);
                    }
                }
                );return false;
            }
        
        
        });
    }

",CClientScript::POS_HEAD);


?>
