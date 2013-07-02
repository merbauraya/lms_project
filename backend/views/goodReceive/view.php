<?php
$this->breadcrumbs=array(
	'Good Receives'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GoodReceive','url'=>array('index')),
	array('label'=>'Create GoodReceive','url'=>array('create')),
	array('label'=>'Update GoodReceive','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete GoodReceive','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GoodReceive','url'=>array('admin')),
);
?>

<h1>View GoodReceive #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'library_id',
		'vendor_code',
		'shipment_date',
		'invoice_no',
		'created_by',
		'date_created',
	),
)); ?>
