

<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-item-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); */?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		echo $form->select2row($model, 'vendor_id', array(
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
				
			}'				 
		)
		
	));
	
	
		echo $form->textFieldRow($model,'invoice_number',array('class'=>'span3','maxlength'=>20));
		echo $form->dropDownListRow($model, 'currency_id',
		CHtml::listData(Currency::model()->findAll(), 'id', 'code'),array('class'=>'span3')); 
		echo $form->textFieldRow($model,'price',array('class'=>'span3','maxlength'=>10)); 
		echo $form->textFieldRow($model,'local_price',array('class'=>'span3','maxlength'=>10));
		echo $form->textFieldRow($model,'replacement_price',array('class'=>'span3','maxlength'=>10));
		
		?>



	<?php //echo $form->textFieldRow($model,'date_last_checked_out',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_seen',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'checkout_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'renewal_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_checked_in',array('class'=>'span5')); ?>

	

	

	<?php //echo $form->textFieldRow($model,'claim_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'category_id',array('class'=>'span5')); ?>

	

	

	

	
<!--	<div class="form-actions"> 
		<?php /*$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); */?>
	</div> -->


<?php //$this->endWidget(); ?>

