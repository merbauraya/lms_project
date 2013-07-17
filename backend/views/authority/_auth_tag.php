<?php
    $tagHead = array();
    
    ob_start();
           $this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Add Tag',
	'size' => 'mini',
	'icon' =>'icon-plus-sign',
    'htmlOptions'=>array('class'=>'btn-secondary addTag',
		'id'=>'btn_addTag',
        'rel'=>'tooltip',
        'onClick'=>'addTag(this);$("#addTagDialog").dialog("open");'
        )
)); 
    
    $btn = ob_get_contents();
    ob_end_clean();
    
    
    
    for ($i=0;$i<10;$i++)
    {
        
        $buffer = CHtml::tag('div',array(
            'id'=>$i*100,
            'class'=>'row-fluid marc-tag'),'',false
        
        );
        $buffer .= $btn;
        $buffer .= CHtml::closeTag('div'); 
        $tagHead[$i*100] =  $buffer;
    }
    
    $n=0; 
    $tabKey=0; 
    foreach ($templates as $template) 
	{
		++$n;
        $tabKey =(int) getTabKey($template->tag);
        //echo $tabKey .'::'. $template->tag. '<br>';
        $tagHead[$tabKey] .=newMarcTag($template->tag,$template->loc_description,$n);
      
	}
    
    //render out tabs
    $this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'0XX', 'content'=>$tagHead[0],'active'=>true),
		array('label'=>'1XX', 'content'=>$tagHead[100]),
		array('label'=>'2XX', 'content'=>$tagHead[200]),
		array('label'=>'3XX', 'content'=>$tagHead[300]),
		array('label'=>'4XX', 'content'=>$tagHead[400]),
		array('label'=>'5XX', 'content'=>$tagHead[500]),
		array('label'=>'6XX', 'content'=>$tagHead[600]),
		array('label'=>'7XX', 'content'=>$tagHead[700]),
		array('label'=>'8XX', 'content'=>$tagHead[800]),
		array('label'=>'9XX', 'content'=>$tagHead[900]),
	
        ),
    ));	
    function newButton($label)
    {
        
    }
    
    function newMarcTag($tag,$tagName,$n)
    {
        $buffer = CHtml::tag('div',array(
				'id'=>$tag.'-'.$n,
				'class'=>'row-fluid marc-tag'),'',false
		); //main row
	
		$buffer .= CHtml::tag('div',array(
					'class'=>'span12'),'',false
		);
       
		$buffer .=CHtml::tag('span',array(
			'class'=>'marc-tag',
			'title'=>$tagName,
			), $tag,true
		);
		$marcTag = MarcTag::tag($tag); //tag description
		
		$buffer .='&nbsp;';
		$buffer .=CHtml::link($tagName,'#',array(
				'onclick'=>'expandTag;'
			));
          
        $buffer .='&nbsp;' .generateLink('Delete this tag','deleteTag','icon-remove');
        if ((int)$tag>10)
            $buffer .='&nbsp;' .generateLink('Show subfield','showSubfield','icon-list');
		$buffer .='&nbsp;' . '<p id="ajax-status-'.$n .'" ></p>';
        /*	
		if ($marcTag['repeatable'])
		{
			$buffer .='&nbsp;';
			$buffer .=generateLink('Repeat this tag','repeatTag','icon-repeat');
			$buffer .='&nbsp;' .generateLink('Delete this tag','deleteTag','icon-remove');
		}*/	
		$buffer .= CHtml::closeTag('div'); //span 12
        $buffer .= CHtml::closeTag('div'); //span 12
		return $buffer;
        
    }
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
            'rel'=>'tooltip',
			'onClick'=>$click,
		)	);
		return $buffer;
		
	}
    function getTabKey($tag)
    {
        $tk='0';
		if ($tag <100) //tag 100
			$tk='0';	
		if ($tag >=100 & $tag <200) //tag 100
			$tk='100';	
		elseif ($tag >=200 & $tag < 300) //200
			$tk='200';
		elseif ($tag >=300 & $tag < 400) //200
			$tk='300';	
		elseif ($tag >=400 & $tag < 500) //200
			$tk='400';	
		elseif ($tag >=500 & $tag < 600) //200
			$tk='500';
		elseif ($tag >=600 & $tag < 700) //200
			$tk='600';	
		elseif ($tag >=700 & $tag < 800) //200
			$tk='700';
		elseif ($tag >=800 & $tag < 900) //200
			$tk='800';
		elseif ($tag >=900 & $tag < 1000) //200
			$tk='900';
		
		return $tk;
        
    }

?>


<?php
Yii::app()->clientScript->registerScript('tag_subfield',"
    window.deleteTag = window.deleteTag || {};
    if (!window.deleteTag.liveClickHandlerAttached) 
    {
        window.deleteTag.liveClickHandlerAttached = true;
        $(document).on('click', '.deleteTag', function(event)
        {

            event.preventDefault();
            var divTag = $(this).parent().closest('div[id]').attr('id');
            var authTag = divTag.substring(0,3);
            var templateID = $('#authorityTemplate').val();
            
            {jQuery.ajax(
                {'id':'sent',
                type:'POST',
                data: {tag: authTag,authType: templateID},
                url:'/authority/deletetag/',
                cache:false,
                success:function(data)
                    {
                        $.lmNotify(data);
                        if (data.status == 'success')
                            $('#' + divTag).remove();
                    }
                    
                }
                );
                
                return false;}

        
        
        
		
        });
    }
    function addTag(elem)
	{
		//event.preventDefault();
        var divTag = $(elem).parent().closest('div[id]').attr('id');
        console.log(divTag);
        var templateID = $('#authorityTemplate').val();
        
        {jQuery.ajax(
            {'id':'sent',
            type:'POST',
            dataType : 'json',
            data: $(this).serialize() + '&template='+ templateID + '&tag='+ divTag,
            url:'/authority/gettemplatetag/',
            cache:false,
            success:function(data)
                {
                   if (data.status == 'failure')
					{
						$('#addTagDialog div.divForForm').html(data.div);
						// Here is the trick: on submit-> once again this function!
						$('#addTagDialog div.divForForm form').submit(addTag);
					}
					else
					{
						$('#addTagDialog div.divForForm').html(data.div);
						setTimeout(\"$('#addTagDialog').dialog('close') \",2000);
	 
					}
                }
                
            }
            );
            
            return false;}

        
        
        
		
	}
    
    
    window.showSubfield = window.showSubfield || {};
    if (!window.showSubfield.liveClickHandlerAttached) 
    {
        window.showSubfield.liveClickHandlerAttached = true;
        $('.showSubfield').live('click',function(event)
        {
       
            
        
            event.preventDefault();
            var divTag = $(this).parent().closest('div[id]').attr('id');
            var authTag = divTag.substring(0,3);
            var nID = divTag.substring(4); //our counter
            var templateID = $('#authorityTemplate').val();
            //check if we already have subfield loaded
            var childSel = '#' + divTag;
            //var childDiv = $(childSel + ' div:first-child').attr('id');
            var childDiv = divTag +'-subfield';
            //console.log(divTag + '::' + childDiv);
            
            if ($('#'+childDiv).length)
            {
                $('#' + childDiv).slideToggle('fast');
                return false;
            }
        
            $(this).siblings('p').addClass('ajax_loading_round');
            console.log($(this).siblings('p'));
            {jQuery.ajax(
                {
                    type: 'POST',
                    data: {tag: authTag,authType: templateID,counter:nID},
                    url:'/authority/loadsubfield/',
                    cache:false,
                    success:function(html)
                    {
                        $('#'+divTag).append(html);
                        $(this).siblings('p').removeClass('ajax_loading_round');
                    }
                    
                });
                return false;
            };
             
        });
    }
    window.showTagSubfield = window.showTagSubfield || {};
    if (!window.showTagSubfield.liveClickHandlerAttached) 
    {
        window.showTagSubfield.liveClickHandlerAttached = true;
        $('.showTagSubfield').live('click',function(event)
        {
       
            
        
            event.preventDefault();
            var divTag = $(this).parent().closest('div[id]').attr('id');
            var authTag = divTag.substring(0,3);
            
            var templateID = $('#authorityTemplate').val();
            //check if we already have subfield loaded
            var childSel = '#' + divTag;
            //var childDiv = $(childSel + ' div:first-child').attr('id');
            var childDiv = divTag.substring(0,3) +'-subfield-sf';
            //console.log(divTag + '::' + childDiv);
            
            if ($('#'+childDiv).length)
            {
                $('#' + childDiv).slideToggle('fast');
                return false;
            }
            {jQuery.ajax(
                {
                    type: 'POST',
                    data: {tag: authTag,authType: templateID},
                    url:'/authority/addtagloadsubfield/',
                    cache:false,
                    success:function(html)
                    {
                        $('#'+divTag).append(html);
                        $(this).siblings('p').removeClass('ajax_loading_round');
                    }
                    
                });
                return false;
            };
             
        });
    }
    window.showSaveSubfield = window.showSaveSubfield || {};
    if (!window.showSaveSubfield.liveClickHandlerAttached) 
    {
        window.showSaveSubfield.liveClickHandlerAttached = true;
        $(document).on('click', '#btn_save_subfield', function(event)
        {
        
            var templateID = $('#authorityTemplate').val();
       
            {jQuery.ajax(
                {
                    type: 'POST',
                    data :$('#template-tag').serialize()+ '&template='+templateID,
                    url:'/authority/savesubfield/',
                    cache:false,
                    dataType: 'json',
                    success:function(data)
                    {
                        $.lmNotify(data);
                        if (data.status == 'success'){
                            
                            $('#template-tag input:checkbox:checked').each(function() {
                                //remove subfield
                                $(this).closest('div').remove();
                            
                            
                            });
                            
                        
                        }
                        
                    }
                    
                });
                return false;
            };
             
        });
    }
    
");


?>
