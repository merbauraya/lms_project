<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

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
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
