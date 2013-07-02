<?php
$this->breadcrumbs=array(
	'Patrons'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Patron','url'=>array('index')),
	array('label'=>'Create Patron','url'=>array('create')),
	array('label'=>'Update Patron','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Patron','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Patron','url'=>array('admin')),
);
?>

<h1>View Patron #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'library_id',
		'patron_category_id',
		'username',
		'password',
		'email',
		'phone1',
		'phone2',
		'login_attempts',
		'last_login_time',
	),
)); ?>
