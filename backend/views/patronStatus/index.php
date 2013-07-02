<?php
$this->breadcrumbs=array(
	'Patron Statuses',
);

$this->menu=array(
	array('label'=>'Create PatronStatus','url'=>array('create')),
	array('label'=>'Manage PatronStatus','url'=>array('admin')),
);
?>

<h1>Patron Statuses</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
