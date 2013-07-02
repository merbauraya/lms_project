<?php
$this->breadcrumbs=array(
	'Marc Uploads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MarcUpload','url'=>array('index')),
	array('label'=>'Manage MarcUpload','url'=>array('admin')),
);
?>

<h1>Create MarcUpload</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>