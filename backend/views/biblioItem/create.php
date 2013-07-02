<?php
$this->breadcrumbs=array(
	'Biblio Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BiblioItem','url'=>array('index')),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>

<h1>Create BiblioItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>