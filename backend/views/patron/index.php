<?php
$this->breadcrumbs=array(
	'Patrons',
);

$this->menu=array(
	array('label'=>'Create Patron','url'=>array('create')),
	array('label'=>'Manage Patron','url'=>array('admin')),
);
?>

<h1>Patrons</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
