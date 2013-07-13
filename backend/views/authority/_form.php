<?php
    $tagHead = array();
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'save-marc',
            'type'=>'horizontal',
            'action'=> array('authority/create'),
        )); 

    
    for ($i=0;$i<10;$i++)
        $tagHead[$i*100] ='';// $sHead;
        
    $arrMarc = array();    
    foreach ($templates as $template) 
	{
		$arrMarc[$template->tag][] = $template;
     //   echo $template->tag;
	}
    $n=0;
    $tabKey='';
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
		/*foreach($marc as $rec)
		{
			
			
			++$n;
			
			$tag = $rec->tag;
			
			$marcTag = MarcTag::tag($rec->tag);
			$subfieldCode = $rec->subfield;
			
			$subField = MarcTag::subfield($rec->tag,$rec->subfield);
			$subfieldName=$subField['name'];
			$default_value=$subField['default_value'];
			//start new subfield
			$tagHead[$tabKey].=newMarcSubField($rec->tag,$subfieldCode,$subfieldName,$default_value,$n,$subField,$marcTag);
		}*/
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
//start new Marc Subfield
	function newMarcSubField($tag,$subfieldCode,$subfieldName,$default_value,$n,$subField,$marcTag)
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
				'class'=>'span4',
                ),'',false);
		$buffer .='&nbsp;';
        /*
		if ((int)$tag< 10) //control field
		{
			$buffer .=CHtml::tag('span',array('style'=>'float:left;padding-top:5px;'),'00',false	);
		}
		else
		{
			$buffer .=CHtml::tag('span',array('style'=>'float:left;padding-top:5px;'),'',false	);
		}
		//label
		//input name: tag-indi1Indi2-subfield-counter
        
        
        
        $buffer .= CHtml::closeTag('span'); */
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
            $buffer .= addIndicator($marcTag,$n,$subfieldCode);
        
		$buffer .=CHtml::closeTag('div'); //span6
        
        	
		//span7 - input text
		$buffer .= CHtml::tag('div',array('class'=>'span7'),'',false);
        $htmlOptions = array();
        $htmlOptions['class']='span11';
        
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
		$buffer .=CHtml::closeTag('div'); //span6
		
		
		//
		$buffer .=CHtml::closeTag('div'); //row for control/marc input
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
    	//end div for marc tag
	function endMarcTag()
	{
		return CHtml::closeTag('div');
	}
    function addIndicator($marcTag,$n,$subfieldCode)
    {
        $buffer='';
        $options = array();
        $options['class']='marc-indicator';
        $options['maxlength']=1;
        $options['readonly']=true;
        if ($marcTag['indi1'])
            unset ($options['readonly']);
        
        $buffer .=CHtml::textField('Marc[indi1-'. $marcTag['tag'].'-'.$subfieldCode.'-'.$n.']','',$options);	
			$buffer .='-';
        unset ($options['readonly']);
        if (!$marcTag['indi2'])
            $options['readonly']=true;
        
        $buffer .=CHtml::textField('Marc[indi2-'. $marcTag['tag'].'-'.$subfieldCode.'-'.$n.']','',$options);
			
			$buffer .='&nbsp;';
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
    
    ?>
