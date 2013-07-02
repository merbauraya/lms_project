<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-vendor-rfq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'acquisition_suggestion_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'vendor_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_sent',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'send_to',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'url_sent',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'response',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'price_per_copy',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'page_password',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'response_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'due_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'currency_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
