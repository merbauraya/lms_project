<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'patron-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
	?>

	<?php echo $form->dropDownListRow($model, 'category_id',
       CHtml::listData(PatronCategory::model()->findAll(), 'id', 'name')); 
	?>
	
	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>125)); ?>

	<?php echo $form->textFieldRow($model,'phone1',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'phone2',array('class'=>'span5','maxlength'=>15)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
