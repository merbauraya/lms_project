<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'budget-transaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<fieldset>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	
	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
?>
<div class="control-group ">
	
		<label class="control-label" for="BudgetTransaction_budget_account_id">Budget Account</label>
	
	<div class="controls">
		<?php  echo CHtml::dropDownList('BudgetTransaction[budget_account_id]','Select Budget Account',CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name')); 
		?>
		
		<?php
		$this->widget('zii.widgets.jui.CJuiButton', array(
'name'=>'button',

'caption'=>'New',
// you can easily change the look of the button by providing the correct class
// ui-button-error, ui-button-primary, ui-button-success
'htmlOptions' => array('class'=>'ui-button-error'),
'onclick'=>new CJavaScriptExpression('function(){alert("Yes");this.blur(); return false;}'),
));
		
		
		$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'New',
	'type' => 'secondary',
	'size' => 'small',
	'icon' =>'icon-file',
	'htmlOptions' => array(
	'onclick'=>new CJavaScriptExpression('function(){alert("Yes");}'
	))
));
		
		?>
	</div>
	<div class="controls">
		<?php
			
		?>
	</div>
	
</div>

		

	



	<?php echo $form->textFieldRow($model,'trans_amount',array('class'=>'span5','maxlength'=>7)); ?>

	

	

	
	
		<?php echo $form->dropDownListRow($model, 'budget_source_id',
       CHtml::listData(BudgetSource::model()->findAll(), 'id', 'name')); 
?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
