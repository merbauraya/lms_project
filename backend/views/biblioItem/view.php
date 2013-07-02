<?php
$this->breadcrumbs=array(
	'Biblio Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BiblioItem','url'=>array('index')),
	array('label'=>'Create BiblioItem','url'=>array('create')),
	array('label'=>'Update BiblioItem','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BiblioItem','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>

<h1>View BiblioItem #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'biblio_id',
		'call_number',
		'code',
		'received_date',
		'order_date',
		'status_id',
		'location_id',
	),
)); ?>
