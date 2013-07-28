<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
    'type'=>'horizontal',
	'method'=>'get',
)); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'control_number',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->dropDownListRow($model, 'smd_id',
		Lookup::getLookupOptions(Lookup::ITEM_SMD),array('class'=>'span5'));
	?>
    
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
