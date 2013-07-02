<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'library_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'patron_category_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>125)); ?>

	<?php echo $form->textFieldRow($model,'phone1',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'phone2',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'login_attempts',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_login_time',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
