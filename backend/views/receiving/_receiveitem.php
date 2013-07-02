<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'good-receive-item-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php //echo $form->textFieldRow($model,'good_receive_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'po_item_id',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'quantity_to_receive',array('class'=>'span1','readonly'=>'readonly')); ?>

    <?php echo $form->textFieldRow($model,'quantity_received',array('class'=>'span1')); ?>

    
    <?php echo $form->textFieldRow($model,'price',array('class'=>'span2','maxlength'=>19)); ?>

    <?php echo $form->textFieldRow($model,'local_price',array('class'=>'span2','maxlength'=>19)); ?>
	
	<?php echo $form->select2row($model, 'budget_id', array(
		'asDropDownList'=>true,
		'data'=>CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name'),
	));
	?>
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

<?php $this->endWidget(); ?>