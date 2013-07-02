<?php
//the javascript that doing the jobs
 $script = "function showItemValue(){
              document.getElementById('templateDiv').innerHTML = document.getElementById('catalog').value;
}";

Yii::app()->clientScript->registerScript('js1', $script, CClientScript::POS_END);
?>
<?php

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'catalog-list',
		'type'=>'horizontal',
		'action'=>array('catalog/RenderCatalogTemplate'),
		
	)); 
	
?>


<div class="control-group">
<?php
	echo CHtml::DropDownList('catalogTemplate', 'Select Template', CHtml::listData(CatalogTemplate::model()->findAll(), 'id', 'name')); 

echo CHtml::ajaxSubmitButton('Load Template',array('RenderCatalogTemplate'),array('update'=>'#templateDiv','id'=>'sent'));
$this->endWidget(); 
?>
</div>
<div id='templateDiv'>
	
	
	
</div>




 