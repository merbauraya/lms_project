<?php
$this->breadcrumbs=array(
	'Patrons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Patron','url'=>array('index')),
	array('label'=>'Manage Patron','url'=>array('admin')),
);
?>

<h1>Create Patron</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>