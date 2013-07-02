<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Receiving Item",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
	
	
?>


<?php
echo $event->sender->menu->run();
echo '<div>';//Step '.$event->sender->currentStep.' of '.$event->sender->stepCount;
//echo '<h3>'.$event->sender->getStepLabel($event->step).'</h3>';
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'receiving-accounting',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'quantity_to_receive',array('class'=>'span5','maxlength'=>30,'readonly'=>'readonly')); 
	echo $form->textFieldRow($model,'quantity_received',array('class'=>'span5','maxlength'=>5));
	echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>10));
	echo $form->textFieldRow($model,'local_price',array('class'=>'span5','maxlength'=>10));
		 echo $form->dropDownListRow($model, 'budget_id',
			CHtml::listData(BudgetAccount::model()->getByLibrary(Yii::app()->user->libraryId),'id','name'));
	
	echo $button;	
?>
	
	

<?php 
	$this->endWidget(); 
	$this->endWidget(); 

?>