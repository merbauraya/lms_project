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
	while ($marc_record = $marc->next()) 
	{
  		foreach ($marc_record->getFields() as $tag=>$value) 
		{
        	
			
			
			
		    if ($value instanceof File_MARC_Control_Field) 
			{
	                //print $value->getData();
	        }
		    else //non control field 
			{
	        	
				foreach ($value->getSubfields() as $code=>$subdata) 
				{
//	                echo '<tr><td>';
					++$n;
					$tagName =MarcTag::getTagDescription($tag) ;
					$subField = MarcTag::getSubFieldDescription($tag.$code);
//					echo  '['.$tag.'] '.$tagName[0];
					
//					echo '</td>';
						
						$indi1 = $value->getIndicator(1);
						$indi2 = $value->getIndicator(2);
//						echo '<td>';
						if (!isset($indi1))
							$indi1 = '_';
//						echo '</td><td>';
						if (!isset($indi2))
							$indi2= '_';
//						echo '</td>';
//						echo '<td>['.  $code.']'. $subField[0]. '</td><td>';
						//add counter as part of the key to ensure uniquness
						$arrKey = $tag.'-'.$indi1.$indi2.'-'. $code.'-'.$n; 
						//store in array for later use
						//tag, tagname, indi1, indi2,subfieldcode, subfield name, data
						$marcArr[$arrKey] = array($tag,$tagName[0], $indi1,$indi2,$code,$subField[0],$subdata->getData()); 
//						echo '<input type="text" class="span5" name="Marc[' .$tag.$code.']" value="'.  $subdata->getData() .'"></td>';
//						echo '</tr>'; 
//						echo '<!--'. $n. '-->';
						
						//print "_$code".'-code-'.$subdata;
	        	}
	     	}
        
    	}
//		echo $n;//count($marcArr);
		//we rebuild the marc tag into array so we can sort later
		ksort($marcArr);
		
		foreach($marcArr as $key=>$val)
		{
			echo '<tr><td>';
			//$tagName = MarcTag::getTagDescription($val[0]);
			//$subField = MarcTag::getSubFieldDescription($key.$val[0]);
			//tag+name,indi1,indi2,subfield,subfield name,data
			echo '['.$val[0].'] '.$val[1];
			echo '</td>';
			echo '<td>';
						if (isset($val[2]))
							echo $val[2];
						echo '</td><td>';
						if (isset($val[3]))
							echo $val[3];
						echo '</td>';
						echo '<td>['.  $val[4].'] '. $val[5]. '</td><td>';
			echo '<input type="text" class="span5" name="Marc[' .$key.']" value="'.  $val[6] .'"></td>';
			
						echo '</tr>';						
			
			
		}
		
		
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