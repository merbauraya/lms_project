<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'invoice-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->textAreaRow($model,'notes',array('class'=>'span6', 'rows'=>3)); ?>
		
	

			
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'id'=>'createquote',
			'label'=>' Save ' ,
		)); ?>

	</div> <!--form-actions-->

<?php $this->endWidget(); ?>