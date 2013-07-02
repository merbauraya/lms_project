<?php
$this->breadcrumbs=array(
	'Budget Accounts',
);

$this->menu=array(
	array('label'=>'Create BudgetAccount','url'=>array('create')),
	array('label'=>'Manage BudgetAccount','url'=>array('admin')),
);
?>

<h1>Budget Accounts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
