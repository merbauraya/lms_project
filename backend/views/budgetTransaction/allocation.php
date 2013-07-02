<?php
$this->breadcrumbs=array(
	'Budget Transactions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BudgetTransaction','url'=>array('index')),
	array('label'=>'Manage BudgetTransaction','url'=>array('admin')),
);
?>
<div class="form-wrapper">
<header role="">
<h6>Budget Allocation</h6>
</header>
<div style="display: block">
<?php echo $this->renderPartial('_allocationform', array('model'=>$model)); ?>
</div>
</div>