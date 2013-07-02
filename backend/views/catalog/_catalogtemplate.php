<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Catalog By Template",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>

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
		<p class="help-block">&nbsp</p>
		<div class="control-group">
			<label class="control-label">Select Template</label>
			<div class="controls">
		<?php
			
			echo CHtml::DropDownList('catalogTemplate', 'Select Template', CHtml::listData(CatalogTemplate::model()->findAll(), 'id', 'name'),array('class'=>'span4')); 
			echo '&nbsp';
		echo CHtml::ajaxSubmitButton('Load Template',array('RenderCatalogTemplate'),array('update'=>'#templateDiv','id'=>'sent'),array('class'=>'btn btn-primary'));
		$this->endWidget(); 

		?>
			</div>
		</div>
		<div id='templateDiv' class="marc-input"></div>
	
	
	
<?php $this->endWidget(); ?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'marc-leader-dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Marc Leader'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

						
	//echo $this->renderPartial('_leader', array());   	
		
?>
	<div class="divForForm"></div>
<?php					
	$this->endWidget();						
?>						



 