<?php
$this->breadcrumbs=array(
	'Catalog Documents',
);

$this->menu=array(
	array('label'=>'Create CatalogDocument','url'=>array('create')),
	array('label'=>'Manage CatalogDocument','url'=>array('admin')),
);
?>

<h1>Catalog Documents</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
