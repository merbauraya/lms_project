<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'patron-category-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name'),array('class'=>'span5')); 
	?>
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->checkBoxRow($model,'is_active'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
