<?php
$this->breadcrumbs=array(
	'Acquisition Requests',
);

$this->menu=array(
	array('label'=>'Create AcquisitionRequest','url'=>array('create')),
	array('label'=>'Manage AcquisitionRequest','url'=>array('admin')),
);
?>

<h1>Acquisition Requests</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
