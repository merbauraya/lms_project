<?php
    $tagHead = array();
    for ($i=0;$i<10;$i++)
        $tagHead[$i*100] ='';// $sHead;
    
    
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
<script type="text/javascript">
    $(".deleteTag").live('click',function()
	{
		var divTag = $(this).parent().closest('div[id]').attr('id');
        var authTag = divTag.substring(0,3);
        var templateID = $('#authorityTemplate').val();
        console.log(authTag);
        {jQuery.ajax(
            {'id':'sent',
            type:'POST',
            data: {tag: authTag,authType: templateID},
            url:'/authority/deletetag/',
            cache:false,
            success:function(html)
                {
                    $.jGrowl('Tag Deleted',
					{
						sticky: false,
						theme : 'lm-success',
						life: 5000
					});
                    $('#' + divTag).remove();
                }
                
            }
            );return false;}

        
        
        
		
	});
    
    $(".showSubfield").live('click',function()
    {
        var divTag = $(this).parent().closest('div[id]').attr('id');
        var authTag = divTag.substring(0,3);
        var nID = divTag.substring(4); //our counter
        var templateID = $('#authorityTemplate').val();
        //check if we already have subfield loaded
        var childSel = '#' + divTag;
        //var childDiv = $(childSel + ' div:first-child').attr('id');
        var childDiv = divTag +'-subfield';
        console.log(divTag + '::' + childDiv);
        
        if ($('#'+childDiv).length)
        {
            $('#' + childDiv).slideToggle('fast');
            return false;
        }
        
        $(this).siblings('p').addClass('ajax_loading_round');
        {jQuery.ajax(
            {
                type: 'POST',
                data: {tag: authTag,authType: templateID,counter:nID},
                url:'/authority/loadsubfield/',
                cache:false,
                success:function(html)
                {
                    $('#'+divTag).append(html);
                    $(this).siblings('p').removeClass("ajax_loading_round");
                }
                
            });
            return false;
        };
         
    });


</script>
