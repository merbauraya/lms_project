<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'good-receive-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->dropDownListRow($model, 'library_id',
       //CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
	?>
	<?php echo $form->select2row($model, 'library_id', array(
		'asDropDownList'=>true,
		'data'=>CHtml::listData(Library::model()->findAll(), 'id', 'name'),
	));
	?>
	<?php echo $form->select2row($model, 'vendor_code', array(
		'asDropDownList' => false,
		'attribute'=>'vendor_code',
		'options' => array(
			'delay'=>300,
			'minimumInputLength'=>3,
			'width' => '50%',
			'closeOnSelect' => false,
			'placeholder' => 'Select Vendor',
			'allowClear' => false,
			'ajax' => array(
				'url' => CController::createUrl('vendor/AjaxGetVendor'),
				'dataType' => 'json',
				'data' => 'js:function(term,page) { return {q: term, page_limit: 10, page: page}; }',
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
				alert(theID);
			}'				 
		)
		
	));
	
	?>
	
	
	<?php echo $form->datepickerRow($model, 'shipment_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
		?>

	
	<?php echo $form->textFieldRow($model,'invoice_no',array('class'=>'span5','maxlength'=>20)); ?>

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
