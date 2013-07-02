<?php
$this->breadcrumbs=array(
	'Biblio Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BiblioItem','url'=>array('index')),
	array('label'=>'Create BiblioItem','url'=>array('create')),
	array('label'=>'View BiblioItem','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>

<h1>Update BiblioItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>