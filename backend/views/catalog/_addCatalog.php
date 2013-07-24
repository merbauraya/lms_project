<div id="marc-input" class="small-input">
<?php

    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'marc-form',
            'type'=>'horizontal',
            'action'=>Yii::app()->createUrl('catalog/SaveMarc'),
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
			$tagHead[$tabKey].=newMarcSubField($rec,$n); //($rec->tag,$subfieldCode,$subfieldName,$default_value,$n,$subField,$marcTag);
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

    //function addIndicator($marcTag,$n,$subfieldCode)
    function addIndicator($rec,$n)
    {
        $buffer='';
        $subfieldCode = $rec->subfield;
        $options = array();
        $options['class']='marc-indicator';
        $options['maxlength']=1;
        $options['readonly']=true;
        $tagInfo = MarcTag::tag($rec->tag,'BIBLIO'); //grab tag info 
        
        if ($tagInfo['indi1'])
            unset ($options['readonly']);
        
        $buffer .=CHtml::textField('Marc[indi1-'. $rec->tag.'-'.$subfieldCode.'-'.$n.']','',$options);	
			$buffer .='-';
        unset ($options['readonly']);
        if (!$tagInfo['indi2'])
            $options['readonly']=true;
        
        $buffer .=CHtml::textField('Marc[indi2-'. $rec->tag.'-'.$subfieldCode.'-'.$n.']','',$options);
			
			$buffer .='&nbsp;';
        return $buffer;
        
    }
	
	//start new Marc Subfield
	//function newMarcSubField($tag,$subfieldCode,$subfieldName,$default_value,$n,$subField,$marcTag)
	function newMarcSubfield($rec,$n)
    {
		
        $tag = $rec->tag;
        $subfieldCode = $rec->subfield;
        $subfieldName = $rec->subfield_name;
        $default_value = '';
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
				'class'=>'span4',
                ),'',false);
		$buffer .='&nbsp;';
    
        
        //$buffer .= CHtml::closeTag('span'); */
        if ((int)$tag>10)
            $inputName = 'Marc['.$tag.'-'.$subfieldCode.'-'.$n.']';
		else
            $inputName = 'Marc['.$tag.'-'.$n.']'; //control field
        if ((int)$tag< 10) //control field
            $buffer .=CHtml::label($subfieldName,$inputName,array('class'=>'control-label'));
		else
            $buffer .=CHtml::label('['.$subfieldCode.'] '.$subfieldName,$inputName,array('class'=>'control-label'));
        
        $buffer .=CHtml::closeTag('div'); //span6
        $buffer .=CHtml::tag('div',array('class'=>'span1'),'',false);
        if ((int)$tag> 10) //control field
            $buffer .= addIndicator($rec,$n);//($marcTag,$n,$subfieldCode);
        
		$buffer .=CHtml::closeTag('div'); //span6
        
        	
		//span7 - input text
		$buffer .= CHtml::tag('div',array('class'=>'span7'),'',false);
        $htmlOptions = array();
        $htmlOptions['class']='span11';
        
        if ((int)$tag==0) //leader
            $htmlOptions['readOnly'] = true;
        
		if ($rec->mandatory)
            $htmlOptions['required'] = true;
        
        $buffer .=CHtml::textField($inputName,$default_value,$htmlOptions);
        
		$buffer.='&nbsp;';
		if (!empty($rec->link))
		{
			$buffer .=generateLink($rec->link_alt_text,'marc','icon-edit',$rec->link);
		}
		
		$buffer .=CHtml::closeTag('div'); //span6
		
		
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
        /*
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
		}*/
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
            'rel'=>'tooltip',
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
<?php 
    $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
            'buttonType'=>'submit',
			'label'=>'Save',
            'icon'=>'icon-ok icon-white',
			
            'htmlOptions' => array('class'=>'btnsaveMarc','name'=>'saveAddAnoter'))); 
    echo '&nbsp;';
    $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'buttonType'=>'submit',
            'label'=>'Save and view Catalog',
            'icon'=>'icon-ok icon-white',
			
            'htmlOptions' => array('class'=>'btnsaveMarc','name'=>'saveViewCatalog'))); 



    echo '&nbsp;';
    $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'buttonType'=>'submit',
            'label'=>'Save and add Item',
            'icon'=>'icon-ok icon-white',
			
            'htmlOptions' => array('class'=>'btnsaveMarc','name'=>'saveAddItem'))); 
        



?>
		

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
                        $('#Marc_000-0').val(data.div);
                        $('#marc-leader-dialog').dialog('close');
                        break;
                        
                }
                
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
		console.log(divTag);
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
		var seq = nextSequence(); //store next id
        cloneDiv.find('[name]').each(function() { 

			//we should hv only input with name attribute
			var elem = $(this);
			//this could be done via regex
			var id = $(this).attr('name');
			var arrId = id.split('-');
			
			if (arrId.length == 4)
			{
				//marc input
				arrId[3]=arrId[3].replace(/\d+/,seq);
				
			
			}else
			{
				arrId[2]=arrId[2].replace(/\d+/,seq);
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






