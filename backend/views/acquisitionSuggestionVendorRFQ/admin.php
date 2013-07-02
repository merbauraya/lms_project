<?php
$this->breadcrumbs=array(
	'Acquisition Suggestion Vendor Rfqs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestionVendorRFQ','url'=>array('index')),
	array('label'=>'Create AcquisitionSuggestionVendorRFQ','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('acquisition-suggestion-vendor-rfq-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Acquisition Suggestion Vendor Rfqs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'acquisition-suggestion-vendor-rfq-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'acquisition_suggestion_id',
		'vendor_id',
		'date_sent',
		'send_to',
		'url_sent',
		/*
		'response',
		'price_per_copy',
		'page_password',
		'response_date',
		'due_date',
		'currency_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
