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


?>

<?php
$sHead = "<table width='100%'>
	<tr>
		<th>Field</th>
		<th>I1</th>
		<th>I2</th>
		<th>Sub Field</th>
		<th width='50%'>Data</th>
	</tr>";
for ($i=0;$i<10;$i++)
	$tagHead[$i*100] = $sHead;

$n = 0;	
$tabKey='';
$marcArr = array();
	
  		foreach ($templates as $template) 
		{
 			++$n;
		    $tag = (int)$template->tag;
			if ($tag >0 & $tag <100) //tag 100
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
			//add counter as part of the key to ensure uniquness
			$key = $template->tag.'-'.$indi1.$indi2.'-'. $template->subfield.'-'.$n; 
			$tagHead[$tabKey] .= '<tr><td>';
			//echo '<tr><td>';
			//echo '['.$template->tag.'] '.$tagName[0];
			$tagHead[$tabKey] .='['.$template->tag.'] '.$marcTag['name'];
			
			//echo '</td><td>';
			$tagHead[$tabKey] .= '</td><td>';
			//echo $indi1;
			$tagHead[$tabKey] .= $indi1;
			//echo '</td><td>';
			$tagHead[$tabKey] .= '</td><td>'; 
			//echo $indi2.'</td><td>';
			$tagHead[$tabKey] .= $indi2.'</td><td>';
			//echo '['.$template->subfield .']'.$subField[0] .'</td><td>';
			$tagHead[$tabKey] .= '['.$template->subfield .']'.$subField['name'] .'</td><td>';
			//echo '<input type="text" class="span5" name="Marc[' .$key.']"'. '></td>';
			$tagHead[$tabKey] .= '<input type="text" class="span12" name="Marc[' .$key.']"'. '></td>'; 
			//echo '</tr>';
			$tagHead[$tabKey] .= '</tr>'; 
			
			
	        	
	     }
        

for ($i=0;$i<10;$i++)
	$tagHead[$i*100] .= '</table>';	
?>

<?php
	echo CHtml::hiddenField('tagCount',$n);
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
		array('label'=>'General', 'content'=>$generalTab),
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
?>
</div?