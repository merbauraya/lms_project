<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'purchase-order-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
?>


	<?php //echo $form->textFieldRow($model,'date_created',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model, 'order_mode_id',
       Lookup::getLookupOptions(PurchaseOrder::ORDER_MODE_CATEGORY));
	   //CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name')); 
	?>
	<?php echo $form->dropDownListRow($model, 'source_id',
       Lookup::getLookupOptions(PurchaseOrder::ORDER_SOURCE));
	   //CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name')); 
	?>
	<?php echo $form->textFieldRow($model,'text_id',array('disabled'=>true,'class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'manual_ref_no',array('class'=>'span5','maxlength'=>30)); ?>
	<?php 
		echo $form->select2row($model, 'vendor_code', array(
			'asDropDownList' => false,
			'attribute'=>'co',
			'options' => array(
				'delay'=>300,
				'minimumInputLength'=>3,
				'width' => '50%',
				'closeOnSelect' => false,
				'placeholder' => 'Select Vendor',
				'allowClear' => false,
				'ajax' => array(
					'url' => CController::createUrl('vendor/AjaxGetVendorList'),
					'dataType' => 'json',
					'data' => 'js:function(term,page) {
						return {q: term, 
								page_limit: 10, 
								page: page,
								ret: "code"}; }',
					'results' => 'js:function(data,page) { return {results: data}; }',
				),
				'initSelection'=>'js:function(element,callback)
								  {var data={id:element.val(),text:element.val()};
								  callback(data);
								  }',
			
			),
			'events'=>array('change'=>'js:function(e)
			{
				var theID=e.val;
				
			}'				 
		)
		
	));
	
	?>
		
	<?php echo $form->datepickerRow($model, 'po_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))

				);
		?>
	<?php echo $form->datepickerRow($model, 'required_ship_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				);
		?>

	

	<?php //echo $form->textFieldRow($model,'department_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'budget_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'status_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
