<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'budget-account-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php 
		
	
	echo $form->dropDownListRow($model, 'library_id',
		CHtml::listData(Library::model()->findAll(), 'id', 'name'),
			
			array('empty'=>'Select Library',
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('department/ajaxGetByLibrary'), //url to call.
				'data'=>array('library'=>'js:this.value','empty'=>1),
				'update'=>'#BudgetAccount_dept_id',
			),
			'class'=>'span5',
		)); 
	?>
	
	
	
	
	<?php echo $form->textFieldRow($model,'budget_code',array('class'=>'span5','maxlength'=>20)); ?>

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
	
	
		echo $form->dropDownListRow($model, 'dept_id',array(' '),array('class'=>'span5'));


		echo $form->checkBoxRow($model,'is_active'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
