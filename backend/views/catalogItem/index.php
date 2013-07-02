<?php
$this->breadcrumbs=array(
	'Biblio Items',
);

$this->menu=array(
	array('label'=>'Create BiblioItem','url'=>array('create')),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>

<h1>Biblio Items</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
