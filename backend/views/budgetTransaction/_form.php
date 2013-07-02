<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'budget-transaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->dropDownListRow($model, 'library_id',
		CHtml::listData(Library::model()->findAll(), 'id', 'name'),
			
			array('empty'=>'Select Library',
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('budgetAccount/ajaxGeListing'), //url to call.
				'data'=>array('library'=>'js:this.value'),
				'update'=>'#BudgetTransaction_budget_account_id',
			),
			'class'=>'span5',
		)); 
	?> 
	
	
	<?php echo $form->dropDownListRow($model, 'trans_code',
       CHtml::listData(BudgetTransactionType::model()->findAll('user_editable=:editable',
				array(':editable'=>true)), 'code', 'name'),
	   array('class'=>'span5')
	 
	   ); 
	   
	    
		echo $form->dropDownListRow($model, 'budget_account_id', array('Select Budget Account'),
			array('class'=>'span5'));
		echo $form->dropDownListRow($model, 'budget_source_id', array('Select Budget Source'),
			array('class'=>'span5'));
	?>
	
	

	<?php echo $form->datepickerRow($model, 'trans_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
		?>

	<?php echo $form->textFieldRow($model,'trans_amount',array('class'=>'span5','maxlength'=>11)); ?>

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<?php 
Yii::app()->clientScript->registerScript('ajaxupdate', "
$('body').on('change','#BudgetTransaction_library_id',function()
	{jQuery.ajax(
		{	
			'type':'POST',
			'url':'/budgetSource/ajaxGeListing/',
			'data':{'library':this.value,'emptyOpt':1},
			'cache':false,
			'success':function(html)
				{
					jQuery(\"#BudgetTransaction_budget_source_id\").html(html)
				}
		})
		;return false;
	}
);
");

?>