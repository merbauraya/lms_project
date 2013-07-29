<?php
$this->breadcrumbs=array(
	'Budget Transactions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetTransaction','url'=>array('index')),
	array('label'=>'Create BudgetTransaction','url'=>array('create')),
	array('label'=>'View BudgetTransaction','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BudgetTransaction','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>

<h1>Update BudgetTransaction <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
