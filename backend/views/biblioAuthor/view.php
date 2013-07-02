<?php
$this->breadcrumbs=array(
	'Biblio Authors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BiblioAuthor','url'=>array('index')),
	array('label'=>'Create BiblioAuthor','url'=>array('create')),
	array('label'=>'Update BiblioAuthor','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BiblioAuthor','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BiblioAuthor','url'=>array('admin')),
);
?>

<h1>View BiblioAuthor #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'biblio_id',
		'author_id',
		'date_created',
		'date_updated',
		'level',
	),
)); ?>
