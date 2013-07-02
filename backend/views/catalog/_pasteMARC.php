<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'paste-marc',
		'type'=>'horizontal',
	)); 
	echo CHtml::textArea('marcData', '');//, array $htmlOptions=array ( ))
	//echo $form->textAreaRow($model, 'textarea', array('class'=>'span8', 'rows'=>5)); 


    echo CHtml::ajaxSubmitButton('Brief Record', array('parseMarcBrief'), array('update'=>'#marcView'),
                array("class"=>"btn btn-primary")
                );  
	 echo CHtml::ajaxSubmitButton('Full Record', array('parseMarcFull'), array('update'=>'#marcView'),
                array("class"=>"btn btn-primary")
                );  
	echo CHtml::ajaxSubmitButton('Marc Tag', array('parseMarc'), array('update'=>'#marcView'),
                array("class"=>"btn btn-primary")
                );
	echo CHtml::ajaxSubmitButton('Edit Marc Record',array('saveMarc'),array('update'=>'#marcView'));
	
	$this->endWidget(); 
	
	
?>
<div id="marcView">


</div>