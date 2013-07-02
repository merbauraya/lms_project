<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'title',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'isbn_issn',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'date_created',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_updated',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'edition',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'language_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'publisher_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'call_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'publish_year',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'collation',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'classification',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'cover_image',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'opac_show'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
