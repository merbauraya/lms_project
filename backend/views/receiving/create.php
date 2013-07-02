<?php
$this->breadcrumbs=array(
	'Good Receives'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GoodReceive','url'=>array('index')),
	array('label'=>'Manage GoodReceive','url'=>array('admin')),
);
?>

<h1>Create GoodReceive</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>