<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'circulation-rule-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name'),array('class'=>'span5')); 
?>
	<?php echo $form->dropDownListRow($model, 'patron_category_id',
       CHtml::listData(PatronCategory::model()->findAll(), 'id', 'name'),array('class'=>'span5')); 
?>
<?php echo $form->dropDownListRow($model, 'smd_id',
       Lookup::getLookupOptions(Lookup::ITEM_SMD),array('class'=>'span5')); 
?>
<?php echo $form->dropDownListRow($model, 'item_category_id',
       Lookup::getLookupOptions(Lookup::ITEM_CATEGORY),array('class'=>'span5')); 
?>

	<?php echo $form->textFieldRow($model,'loan_period',array('class'=>'span3')); ?>
	<?php echo $form->dropDownListRow($model, 'period_type',
       array(CirculationRule::PERIOD_DAY=>'Day',CirculationRule::PERIOD_HOUR=>'Hour'),array('class'=>'span3')); 
?>
	<?php echo $form->textFieldRow($model,'fine_per_period',array('class'=>'span3','maxlength'=>10)); ?>

	
	<?php echo $form->textFieldRow($model,'item_count_limit',array('class'=>'span3')); ?>

	
	<?php echo $form->textFieldRow($model,'max_renewal_count',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'max_reservation_count',array('class'=>'span3')); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
