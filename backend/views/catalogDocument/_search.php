<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'catalog_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'library_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'location_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'book_number',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'classification_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'call_number',array('class'=>'span5','maxlength'=>40)); ?>

	<?php echo $form->textFieldRow($model,'document_status_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'category_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'control_number',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
