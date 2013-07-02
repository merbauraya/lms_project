<?php
$this->breadcrumbs=array(
	'Acquisition Suggestion Vendor Rfqs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestionVendorRFQ','url'=>array('index')),
	array('label'=>'Create AcquisitionSuggestionVendorRFQ','url'=>array('create')),
	array('label'=>'Update AcquisitionSuggestionVendorRFQ','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete AcquisitionSuggestionVendorRFQ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AcquisitionSuggestionVendorRFQ','url'=>array('admin')),
);
?>

<h1>View AcquisitionSuggestionVendorRFQ #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'acquisition_suggestion_id',
		'vendor_id',
		'date_sent',
		'send_to',
		'url_sent',
		'response',
		'price_per_copy',
		'page_password',
		'response_date',
		'due_date',
		'currency_id',
	),
)); ?>
