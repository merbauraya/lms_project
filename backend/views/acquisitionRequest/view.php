<?php
$this->breadcrumbs=array(
	'Acquisition Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AcquisitionRequest','url'=>array('index')),
	array('label'=>'Create AcquisitionRequest','url'=>array('create')),
	array('label'=>'Update AcquisitionRequest','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete AcquisitionRequest','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AcquisitionRequest','url'=>array('admin')),
);
?>

<h1>View AcquisitionRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'requested_by',
		'request_date',
		'status',
		'currency_id',
		'vendor_id',
		'notes',
		'budget_id',
		'library_id',
		'request_mode_id',
		'approved_by',
		'approved_date',
		'rejected_by',
		'rejected_reason',
		'rejected_date',
		'expected_purchase_date',
	),
)); ?>
