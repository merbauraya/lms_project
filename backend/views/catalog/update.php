<?php
$this->breadcrumbs=array(
	'Catalogs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Catalog','url'=>array('index')),
	array('label'=>'Create Catalog','url'=>array('create')),
	array('label'=>'View Catalog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Catalog','url'=>array('admin')),
);
?>

<h1>Update Catalog <?php echo $model->id; ?></h1>

<?php //echo $this->renderPartial('_form',array('model'=>$model)); ?>