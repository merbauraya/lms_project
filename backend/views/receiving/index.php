<?php
$this->breadcrumbs=array(
	'Good Receives',
);

$this->menu=array(
	array('label'=>'Create GoodReceive','url'=>array('create')),
	array('label'=>'Manage GoodReceive','url'=>array('admin')),
);
?>

<h1>Good Receives</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
