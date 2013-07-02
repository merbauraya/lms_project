<?php
$this->breadcrumbs=array(
	'Biblio Authors',
);

$this->menu=array(
	array('label'=>'Create BiblioAuthor','url'=>array('create')),
	array('label'=>'Manage BiblioAuthor','url'=>array('admin')),
);
?>

<h1>Biblio Authors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
