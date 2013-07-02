<?php
$this->breadcrumbs=array(
	'Biblio Authors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BiblioAuthor','url'=>array('index')),
	array('label'=>'Manage BiblioAuthor','url'=>array('admin')),
);
?>

<h1>Create BiblioAuthor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>