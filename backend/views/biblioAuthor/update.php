<?php
$this->breadcrumbs=array(
	'Biblio Authors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BiblioAuthor','url'=>array('index')),
	array('label'=>'Create BiblioAuthor','url'=>array('create')),
	array('label'=>'View BiblioAuthor','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BiblioAuthor','url'=>array('admin')),
);
?>

<h1>Update BiblioAuthor <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>