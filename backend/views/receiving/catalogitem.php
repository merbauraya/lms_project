<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Catalog Item",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
	
	
?>

<?php
echo $event->sender->menu->run();
echo '<div>Step '.$event->sender->currentStep.' of '.$event->sender->stepCount;
echo '<h3>'.$event->sender->getStepLabel($event->step).'</h3>';
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-item-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->dropDownListRow($model, 'owner_library',
		CHtml::listData(Library::model()->findAll(), 'id', 'name'),
			
			array('empty'=>'Select Library',
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('lookup/GetLocationByLibrary'), //url to call.
				'data'=>array('library'=>'js:this.value'),
				'update'=>'#CatalogItem_location_id',
			)
		)); 
	?>
	<?php echo $form->dropDownListRow($model, 'location_id');
	
	?>
	

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>25)); ?>

	

	

	<?php echo $form->textFieldRow($model,'call_number',array('class'=>'span5','maxlength'=>255)); ?>



	<?php //echo $form->textFieldRow($model,'date_last_checked_out',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_seen',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'checkout_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'renewal_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_checked_in',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'control_number',array('class'=>'span5','maxlength'=>30)); ?>
	
	<?php echo $form->dropDownListRow($model, 'withdrawn_status',
		Lookup::getLookupOptions(Lookup::ITEM_WITHDRAWN_STATUS));
	?>
	
	<?php echo $form->dropDownListRow($model, 'condition_id',
		Lookup::getLookupOptions(Lookup::ITEM_CONDITION_STATUS));
	?>
	<?php echo $form->dropDownListRow($model, 'smd_id',
		Lookup::getLookupOptions(Lookup::ITEM_SMD));
	?>
	<?php echo $form->dropDownListRow($model, 'lost_status',
		Lookup::getLookupOptions(Lookup::ITEM_LOST_STATUS));
	?>
	<?php echo $form->dropDownListRow($model, 'not_for_loan_status',
		Lookup::getLookupOptions(Lookup::ITEM_NOTFORLOAN));
	?>

	

	<?php //echo $form->textFieldRow($model,'claim_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'category_id',array('class'=>'span5')); ?>

	

	

	

	
	<?php echo $button ;?>


<?php 
	$this->endWidget(); //form
	$this->endWidget(); //lmbox
?>
