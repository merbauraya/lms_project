<div class="row-fluid">
	
	<div class="span8">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'circulation-rule-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo CHtml::hiddenField('allow-checkout','0') ?>

<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name'),array('class'=>'span7')); 
 echo $form->select2row($model, 'patron_username', array(
		'asDropDownList' => false,
		'attribute'=>'patron_username',
		'options' => array(
			'delay'=>300,
			'minimumInputLength'=>3,
			'width' => '60%',
			'closeOnSelect' => false,
			'placeholder' => 'Select Patron',
			'allowClear' => false,
			'ajax' => array(
				'url' => CController::createUrl('patron/AjaxGetPatron'),
				'dataType' => 'json',
				'data' => 'js:function(term,page) 
							{ return {
								q: term, 
								page_limit: 10, 
								page: page,
								ret: "uname",
								lib: $("#CirculationTrans_library_id").val()}; }',
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
				console.log(e);
				
			}'				 
		)
		
	));
	
 echo $form->select2row($model, 'accession_number', array(
		'asDropDownList' => false,
		'attribute'=>'accession_number',
		'options' => array(
			'delay'=>300,
			'minimumInputLength'=>3,
			'width' => '40%',
			'closeOnSelect' => false,
			'placeholder' => 'Select Accession',
			'allowClear' => false,
			'ajax' => array(
				'url' => CController::createUrl('CatalogItem/AjaxGetItem'),
				'dataType' => 'json',
				'data' => 'js:function(term,page) 
							{ return {
								q: term, 
								page_limit: 10, 
								page: page,
								ret: "accession",
								lib: $("#CirculationTrans_library_id").val()}; }',
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
<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Checkout',
		)); ?>
	</div>
<?php $this->endWidget(); ?>
	</div> <!--span10-->
	<div class="span4 no-left-margin no-right-margin">
		<?php
			$this->beginWidget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>array(
		array('label'=>'Patron', 'content'=>'Patron Status', 'active'=>true),
		array('label'=>'Accession', 'content'=>'Accession Info'),
		array('label'=>'Item Entry', 'content'=>'Content'),
		
	),
));

$this->endWidget();

		?>
	
	</div> <!--span2-->
</div> <!--row-fluid-->
