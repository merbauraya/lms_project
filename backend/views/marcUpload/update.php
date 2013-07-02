<?php
$this->breadcrumbs=array(
	'Marc Uploads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MarcUpload','url'=>array('index')),
	array('label'=>'Create MarcUpload','url'=>array('create')),
	array('label'=>'View MarcUpload','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage MarcUpload','url'=>array('admin')),
);
?>

<h1>Update MarcUpload <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>