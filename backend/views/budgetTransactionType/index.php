<?php
$this->breadcrumbs=array(
	'Budget Transaction Types',
);

$this->menu=array(
	array('label'=>'Create BudgetTransactionType','url'=>array('create')),
	array('label'=>'Manage BudgetTransactionType','url'=>array('admin')),
);
?>

<h1>Budget Transaction Types</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
