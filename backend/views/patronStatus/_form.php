<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'patron-status-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>80)); ?>

	<?php echo $form->checkBoxRow($model,'allow_checkout'); ?>

	<?php echo $form->checkBoxRow($model,'allow_checkin'); ?>

	<?php echo $form->checkBoxRow($model,'allow_reserve'); ?>

	<?php echo $form->checkBoxRow($model,'allow_backend_login'); ?>

	<?php echo $form->checkBoxRow($model,'allow_opac_login'); ?>

	<?php echo $form->checkBoxRow($model,'allow_renew'); ?>

	<?php echo $form->checkBoxRow($model,'allow_comment'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
