<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'suggested_by',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'suggest_date',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'author',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'isbn_issn',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'publisher',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'publication_place',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'edition',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'no_of_copy',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'currency_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>6)); ?>

	<?php //echo $form->textFieldRow($model,'local_price',array('class'=>'span5','maxlength'=>6)); ?>

	<?php //echo $form->textFieldRow($model,'vendor_id',array('class'=>'span5')); ?>

	<?php //echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'budget_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'library_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
