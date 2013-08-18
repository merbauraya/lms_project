<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'budget-account-form',
	'enableAjaxValidation'=>true,
	'type'=>'horizontal',
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        
	),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	
	<?php
        echo $form->dropDownListRow($model, 'location_id',Location::getDropDownList(true),array('class'=>'span5'));
        echo $form->dropDownListRow($model, 'dept_id',Department::getDropDownList(true),array('class'=>'span5'));
    
        echo $form->textFieldRow($model,'budget_code',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>
	
		<?php echo $form->datePickerRow($model, 'start_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
		?>
	<?php echo $form->datePickerRow($model, 'end_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
	
	
		


		echo $form->checkBoxRow($model,'is_active'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
