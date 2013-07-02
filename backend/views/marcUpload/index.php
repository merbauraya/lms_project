<?php
$this->breadcrumbs=array(
	'Marc Uploads',
);

$this->menu=array(
	array('label'=>'Create MarcUpload','url'=>array('create')),
	array('label'=>'Manage MarcUpload','url'=>array('admin')),
);
?>

<h1>Marc Uploads</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
