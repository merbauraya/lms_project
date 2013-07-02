<?php
$this->breadcrumbs=array(
	'Patrons'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Patron','url'=>array('index')),
	array('label'=>'Create Patron','url'=>array('create')),
	array('label'=>'View Patron','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Patron','url'=>array('admin')),
);
?>

<h1>Update Patron <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>