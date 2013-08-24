<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'type'=>'horizontal',
)); ?>

	

	<?php echo $form->textFieldRow($model,'requested_by',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'request_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status_id',array('class'=>'span5')); ?>

	

	<?php echo $form->textFieldRow($model,'budget_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'library_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'request_mode_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approved_by',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approved_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rejected_by',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rejected_reason',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'rejected_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'expected_purchase_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
