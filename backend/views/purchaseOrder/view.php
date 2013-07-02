<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseOrder','url'=>array('index')),
	array('label'=>'Create PurchaseOrder','url'=>array('create')),
	array('label'=>'Update PurchaseOrder','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PurchaseOrder','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseOrder','url'=>array('admin')),
);
?>

<h1>View PurchaseOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'created_by',
		'date_created',
		'order_mode_id',
		'source_id',
		'modified_by',
		'modified_date',
		'manual_ref_no',
		'vendor_id',
		'po_date',
		'text_id',
		'required_ship_date',
		'department_id',
		'budget_id',
		'status_id',
	),
)); ?>
