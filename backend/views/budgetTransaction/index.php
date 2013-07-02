<?php
$this->breadcrumbs=array(
	'Budget Transactions',
);

$this->menu=array(
	array('label'=>'Create BudgetTransaction','url'=>array('create')),
	array('label'=>'Manage BudgetTransaction','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => null, 'flash' => '')); 

?>

<h1>Budget Transactions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
