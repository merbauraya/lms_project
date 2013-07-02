<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'save-marc',
		'type'=>'horizontal',
	)); 
?>	

<table width='100%'>
	<tr>
		<th>Field</th>
		<th>I1</th>
		<th>I2</th>
		<th>Sub Field</th>
		<th>Data</th>
	</tr>
<?php
$n = 0;	
$marcArr = array();
	
  		foreach ($templates as $template) 
		{
 			++$n;
		    $tagName = MarcTag::getTagDescription($template->tag);
			$subField = MarcTag::getSubFieldDescription($template->tag.$template->subfield);
			$indi1 = $template->indi1;
			$indi2 = $template->indi2;
		

			if (!isset($indi1))
				$indi1 = '_';
			if (!isset($indi2))
				$indi2= '_';
			//add counter as part of the key to ensure uniquness
			$key = $template->tag.'-'.$indi1.$indi2.'-'. $template->subfield.'-'.$n; 
			echo '<tr><td>';
			echo '['.$template->tag.'] '.$tagName[0];
			echo '</td><td>';
			echo $indi1;
			echo '</td><td>';
			echo $indi2.'</td><td>';
			echo '['.$template->subfield .']'.$subField[0] .'</td><td>';
			echo '<input type="text" class="span5" name="Marc[' .$key.']"'. '></td>';
			echo '</tr>';
			
			
	        	
	     }
        
?>
	
</table>

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
		,'htmlOptions' => array('name'=>'saveMarcRecord'))); ?>
	</div>
<?php
$this->endWidget(); 
?>