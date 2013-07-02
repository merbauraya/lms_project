<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'biblio-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<div class="well">
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span6')); ?>

	<?php echo $form->textFieldRow($model,'isbn_issn',array('class'=>'span4','maxlength'=>20)); ?>
	

	<?php echo $form->textFieldRow($model,'edition',array('class'=>'span4','maxlength'=>50)); ?>

	
		<?php echo $form->dropDownListRow($model, 'language_id',
       CHtml::listData(Language::model()->findAll(), 'id', 'name')); ?>

	
		<?php echo $form->dropDownListRow($model, 'publisher_id',
       CHtml::listData(Publisher::model()->findAll(), 'id', 'name')); ?>
	<?php echo $form->textFieldRow($model,'call_number',array('class'=>'span4','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'publish_year',array('class'=>'span4','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'collation',array('class'=>'span4','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'classification',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->fileFieldRow($model,'cover_image',array('class'=>'span5','maxlength'=>100)); ?>

	
	 <?php echo $form->toggleButtonRow($model, 'opac_show'); ?>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
