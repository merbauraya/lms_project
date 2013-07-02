

<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-item-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); */?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->select2row($model, 'control_number', array(
		'asDropDownList' => false,
		'attribute'=>'control_number',
		'options' => array(
			'delay'=>300,
			'minimumInputLength'=>3,
			'width' => '50%',
			'closeOnSelect' => false,
			'placeholder' => 'Select Control Number',
			'allowClear' => false,
			'ajax' => array(
				'url' => CController::createUrl('catalog/ajaxGetCatalog'),
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
	
	?>
	
	<?php echo $form->dropDownListRow($model, 'owner_library',
		CHtml::listData(Library::model()->findAll(), 'id', 'name'),
			
			array('empty'=>'Select Library',
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('lookup/GetLocationByLibrary'), //url to call.
				'data'=>array('library'=>'js:this.value'),
				'update'=>'#CatalogItem_location_id',
			),
			'class'=>'span5',
		)); 
	?>
	<?php echo $form->dropDownListRow($model, 'location_id',array('Select Location'),array('class'=>'span5'));
	
	?>
	

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>25)); ?>

	

	

	<?php //echo $form->textFieldRow($model,'call_number',array('class'=>'span5','maxlength'=>255)); ?>



	<?php //echo $form->textFieldRow($model,'date_last_checked_out',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_seen',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'checkout_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'renewal_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'date_last_checked_in',array('class'=>'span5')); ?>
	<?php echo $form->dropDownListRow($model, 'smd_id',
		Lookup::getLookupOptions(Lookup::ITEM_SMD),array('class'=>'span5'));
	?>
	<?php echo $form->dropDownListRow($model, 'category_id',
		Lookup::getLookupOptions(Lookup::ITEM_CATEGORY),array('class'=>'span5'));
	?>
	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->dropDownListRow($model, 'withdrawn_status',
		Lookup::getLookupOptions(Lookup::ITEM_WITHDRAWN_STATUS),array('class'=>'span5'));
	?>
	
	<?php echo $form->dropDownListRow($model, 'condition_id',
		Lookup::getLookupOptions(Lookup::ITEM_CONDITION_STATUS),array('class'=>'span5'));
	?>
	
	
	<?php echo $form->dropDownListRow($model, 'lost_status',
		Lookup::getLookupOptions(Lookup::ITEM_LOST_STATUS),array('class'=>'span5'));
	?>
	<?php echo $form->dropDownListRow($model, 'not_for_loan_status',
		Lookup::getLookupOptions(Lookup::ITEM_NOTFORLOAN),array('class'=>'span5'));
	?>


