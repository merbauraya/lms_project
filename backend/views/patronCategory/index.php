<?php
$this->breadcrumbs=array(
	'Patron Categories',
);

$this->menu=array(
	array('label'=>'Create PatronCategory','url'=>array('create')),
	array('label'=>'Manage PatronCategory','url'=>array('admin')),
);
?>

<h1>Patron Categories</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
