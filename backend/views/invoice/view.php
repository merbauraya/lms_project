<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Create Invoice','url'=>array('create')),
	array('label'=>'Update Invoice','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Invoice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
?>

<h1>View Invoice #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'library_id',
		'vendor_id',
		'po_id',
		'invoice_no',
		'invoice_date',
		'date_created',
		'created_by',
		'status_id',
		'due_date',
		'currency_id',
		'invoice_amount',
		'paid_amount',
		'last_paid_date',
	),
)); ?>
