<div id="marc-input" class="small-input">
<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'save-marc',
		'type'=>'horizontal',
		'action'=> array('catalog/CreateByTemplate'),
	)); 


//we should have 9 tab.. 100 - 900

$tagHead= array();
$generalTab = '<div class="control-group">
				<label class="control-label">Available in Opac</label>
				<div class="controls">'.
				CHtml::checkBox('marc[opac_release]',false,array('value'=>'0')).
				'</div></div>';




for ($i=0;$i<10;$i++)
	$tagHead[$i*100] ='';// $sHead;

$n = 0;	
$tabKey='';
$saveTag='';
$marcArr = array();
	$arrMarc = array();
	//rebuild array for marc tag grouping
	foreach ($templates as $template) 
	{
		$arrMarc[$template->tag][] = $template;
	}
	
	//get all tag
	foreach ($arrMarc as $key=>$marc)
	{
		//echo $key. '<br>';
		++$n;
		$tabKey = getTabKey($key);
		$marcTag = MarcTag::tag($key); //tag description
		$tagName =$marcTag['name'];
		//add new marc tag entry
		$tagHead[$tabKey] .=newMarcTag($key,$tagName,$n);
		//get all subfield under tag
		foreach($marc as $rec)
		{
			
			
			++$n;
			//echo '->' .$rec->tag.':'.$rec->subfield. '::tabkey='.$tabKey.'<br>';
			$tag = $rec->tag;
			
			//echo $tabKey;
			//echo $rec->tag . '::'. $rec->subfield. '<br>' ;
			$marcTag = MarcTag::tag($rec->tag);
			$subfieldCode = $rec->subfield;
			
			$subField = MarcTag::subfield($rec->tag,$rec->subfield);
			$subfieldName=$subField['name'];
			$default_value=$subField['default_value'];
			//start new subfield
			$tagHead[$tabKey].=newMarcSubField($rec->tag,$subfieldCode,$subfieldName,$default_value,$n,$subField);
		}
		$tagHead[$tabKey].=endMarcTag();
	}
	echo CHtml::hiddenField('tagCount',$n,array(
			'id'=>'tagCounter',
	));
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

/*
	
  		foreach ($templates as $template) 
		{
 			
			++$n;
		    $tag = (int)$template->tag;
			if ($tag <100) //tag 100
				$tabKey='0';	
			if ($tag >=100 & $tag <200) //tag 100
				$tabKey='100';	
			elseif ($tag >=200 & $tag < 300) //200
				$tabKey='200';
			elseif ($tag >=300 & $tag < 400) //200
				$tabKey='300';	
			elseif ($tag >=400 & $tag < 500) //200
				$tabKey='400';	
			elseif ($tag >=500 & $tag < 600) //200
				$tabKey='500';
			elseif ($tag >=600 & $tag < 700) //200
				$tabKey='600';	
			elseif ($tag >=700 & $tag < 800) //200
				$tabKey='700';
			elseif ($tag >=800 & $tag < 900) //200
				$tabKey='800';
			elseif ($tag >=900 & $tag < 1000) //200
				$tabKey='900';
			$marcTag = MarcTag::tag($template->tag);
			
			$tagName =$marcTag['name'];
			$subField = MarcTag::subfield($template->tag,$template->subfield);
			
			$indi1 = $template->indi1;
			$indi2 = $template->indi2;
	
			if (!isset($indi1))
				$indi1 = '_';
			if (!isset($indi2))
				$indi2= '_';
			
			//row fluid - 
			
			if ($saveTag != $template->tag) {
			$tagHead[$tabKey] .= CHtml::tag('div',array(
				'id'=>$template->tag,
				'class'=>'row-fluid marc-tag'),'',false
			); //main row
				$tagHead[$tabKey] .= CHtml::tag('div',array(
					'class'=>'span12'),'',false
				);
					$tagHead[$tabKey] .=CHtml::tag('span',array(
						'class'=>'marc-tag',
						'title'=>$marcTag['name'],
						),
						$template->tag,
						true
					
					
					);
			
			$tagHead[$tabKey] .='&nbsp;';
			$tagHead[$tabKey] .=CHtml::link($marcTag['name'],'#',array(
				'onclick'=>'expandTag();'
			));
				
			}
			
			//now generate div for subfield
			$tagHead[$tabKey] .= CHtml::tag('div',array(
				'id'=>$template->tag . $template->subfield,
				'class'=>'row-fluid marc-subfield'),'',false
			);
			
			//$tagHead[$tabKey] .= CHtml::tag('div',array('class'=>'row-fluid sp-subfield'),'',false);
			$tagHead[$tabKey] .= CHtml::tag('div',array(
				'class'=>'span4'),'',false);
			$tagHead[$tabKey] .='&nbsp;';
			if ((int)$template->tag< 10) //control field
			{
				$tagHead[$tabKey] .=CHtml::tag('span',array('style'=>'float:left'),'00',true	);
			}
			else
			{
				$tagHead[$tabKey] .=CHtml::tag('span',array('style'=>'float:left'),$template->subfield,true	);
			}
			
			//input name: tag-indi1Indi2-subfield-counter
			$inputName = $template->tag.'-'.'__-'.$template->subfield.'-'.$n;
			$tagHead[$tabKey] .=CHtml::label($subField['name'],$inputName,array('class'=>'control-label'));
			$tagHead[$tabKey] .=CHtml::closeTag('div'); //span4
			
			//span8
			$tagHead[$tabKey] .= CHtml::tag('div',array('class'=>'span8'),'',false);
			$tagHead[$tabKey] .=CHtml::textField($inputName,$subField['default_value'],array(
				'class'=>'span5',
			));
			$tagHead[$tabKey] .=CHtml::closeTag('div'); //span8
			
			
			//
			$tagHead[$tabKey] .=CHtml::closeTag('div'); //row for control/marc input
			if ($saveTag != $template->tag)
			{
				$tagHead[$tabKey] .=CHtml::closeTag('div'); //marc-tag
				$tagHead[$tabKey] .=CHtml::closeTag('div'); //marc-tag
			}
			$saveTag = $template->tag;
	        	
	     }
        
*/
//for ($i=0;$i<10;$i++)
	//$tagHead[$i*100] .= '</table>';	
	
	//start new Marc Subfield
	function newMarcSubField($tag,$subfieldCode,$subfieldName,$default_value,$n,$subField)
	{
		//set counter to zero for leader
        if ((int)$tag ==0)
            $n=0;
        
        $buffer='';
		//opening div for subfield
		$buffer .= CHtml::tag('div',array(
				'id'=>$tag .'-'. $subfieldCode.'-'.$n,
				'class'=>'row-fluid marc-subfield'),'',false
		);
		$buffer .= CHtml::tag('div',array(
				'class'=>'span4'),'',false);
		$buffer .='&nbsp;';
		if ((int)$tag< 10) //control field
		{
			$buffer .=CHtml::tag('span',array('style'=>'float:left'),'00',true	);
		}
		else
		{
			$buffer .=CHtml::tag('span',array('style'=>'float:left'),$subfieldCode,true	);
		}
		//label
		//input name: tag-indi1Indi2-subfield-counter
		$inputName = 'Marc['.$tag.'-'.'__-'.$subfieldCode.'-'.$n.']';
		$buffer .=CHtml::label($subfieldName,$inputName,array('class'=>'control-label'));
		$buffer .=CHtml::closeTag('div'); //span4
			
		//span8 - input text
		$buffer .= CHtml::tag('div',array('class'=>'span8'),'',false);
        $htmlOptions = array();
        $htmlOptions['class']='span8';
        
        if ((int)$tag==0) //leader
            $htmlOptions['readOnly'] = true;
        
		if ($subField['mandatory'])
            $htmlOptions['required'] = true;
        
        $buffer .=CHtml::textField($inputName,$default_value,$htmlOptions);
        
		$buffer.='&nbsp;';
		if (!empty($subField['link']))
		{
			$buffer .=generateLink($subField['link_alt_text'],'marc','icon-edit',$subField['link']);
		}
		if ($subField['repeatable'])
		{
		
		}
		$buffer .=CHtml::closeTag('div'); //span8
		
		
		//
		$buffer .=CHtml::closeTag('div'); //row for control/marc input
		return $buffer;
		
		
	
	}
	
   
	
	//start new div for marc tag
	function newMarcTag($tag,$tagName,$n)
	{
		$buffer='';
		$buffer .= CHtml::tag('div',array(
				'id'=>$tag.'-'.$n,
				'class'=>'row-fluid marc-tag'),'',false
		); //main row
	
		$buffer .= CHtml::tag('div',array(
					'class'=>'span12'),'',false
		);
		if ((int)$tag>9) //non control tag has indicator
		{
			$buffer .=CHtml::textField('Marc['.$tag.'-indi1-'.$n.']','',array(
				'class'=>'marc-indicator',
				'maxlength'=>'1',
				
			));	
			$buffer .='&nbsp;';
			$buffer .=CHtml::textField('Marc['.$tag.'-indi2-'.$n.']','',array(
				'class'=>'marc-indicator',
                'maxlength'=>'1',
			));
			$buffer .='&nbsp;';
		}
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
			
		if ($marcTag['repeatable'])
		{
			$buffer .='&nbsp;';
			$buffer .=generateLink('Repeat this tag','repeatTag','icon-repeat');
			$buffer .='&nbsp;' .generateLink('Delete this tag','deleteTag','icon-remove');
		}	
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
	//end div for marc tag
	function endMarcTag()
	{
		return CHtml::closeTag('div');
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


<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
			'id'=>'saveRecord'
		,'htmlOptions' => array('name'=>'saveMarcRecord'))); ?>
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'label'=>'Cancel',
			'id'=>'cancelSave'
		,'htmlOptions' => array('name'=>'CancelMarcRecord'))); ?>
	</div>
<?php
$this->endWidget(); 
?>
</div>

<script type="text/javascript">

	function editLeader()
	{
		<?php echo CHtml::ajax(array(
        'url'=>array('catalog/showleadereditor'),
        'data'=> "js:$(this).serialize()",
        'type'=>'post',
        'dataType'=>'json',
        'success'=>"function(data)
            {
                switch(data.status)
                {
                    case 'failure':
                        $('#marc-leader-dialog div.divForForm').html(data.div);
                        $('#marc-leader-dialog div.divForForm form').submit(editLeader);
                        break;
                        
                    case 'leader':
                        console.log(data.div);
                        $('#Marc_000-__-_-0').val(data.div);
                        $('#marc-leader-dialog').dialog('close');
                        break;
                        
                }
                /*
                if (data.status == 'failure')
                {
                    $('#marc-leader-dialog div.divForForm').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#marc-leader-dialog div.divForForm form').submit(editLeader);
                }
                else
                {
                    $('#marc-leader-dialog div.divForForm').html(data.div);
                    setTimeout(\"$('#marc-leader-dialog').dialog('close') \",2000);
 
                }*/
 
        } ",
    ))?>;
		return false;
	}
	
	$(".deleteTag").live('click',function()
	{
		var divTag = $(this).parent().closest('div[id]').attr('id');
		$('#' + divTag).remove();
	});
	
	$(".repeatTag").live('click',function()
	{
		//get parent Tag
		var divTag = $(this).parent().closest('div[id]').attr('id');
		
		//$("#" + inputID + ".inputfield") s
		var cloneDiv = $('#' + divTag).clone();
		
		//change all id
		cloneDiv.find('[id]').andSelf().each(function() { 

			//console.log($(this).attr('id'));
			var elem = $(this);
			var newID = elem.attr('id').replace(/\d+$/, nextSequence());
			elem.attr('id', newID);
			//console.log(elem);
		});
		//change all input name with running number
		cloneDiv.find('[name]').each(function() { 

			//console.log($(this));
			var elem = $(this);
			//this could be done via regex
			var id = $(this).attr('name');
			var arrId = id.split('-');
			
			if (arrId.length == 4)
			{
				//marc input
				arrId[3]=arrId[3].replace(/\d+/,nextSequence());
				
			
			}else
			{
				arrId[2]=arrId[2].replace(/\d+/,nextSequence());
			}
			var newID = arrId.join('-');
			//console.log('old='+id +' new='+newID);
			
			elem.attr('name', newID);
			
		});
		
		cloneDiv.insertAfter('div#'+divTag +':last');
	});
	
	function nextSequence()
	{
		var val = parseInt($("#tagCounter").val())+1 ;
		//console.log(val);
		$("#tagCounter").val(val);
		return val;
	}
	

</script>






