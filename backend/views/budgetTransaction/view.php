<?php
$this->breadcrumbs=array(
	'Budget Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BudgetTransaction','url'=>array('index')),
	array('label'=>'Create BudgetTransaction','url'=>array('create')),
	array('label'=>'Update BudgetTransaction','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BudgetTransaction','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetTransaction','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Budget Transaction",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'List','url'=>array('index',)),
								array('label'=>'New Transaction','url'=>array('create',)),
								array('label'=>'Update','url'=>array('update','id'=>$model->id)),
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'budget_account_id',
		'library_id',
		'trans_code',
		'trans_date',
		'trans_amount',
		'date_created',
		'created_by',
		'budget_source_id',
	),
)); 

	$this->endWidget();

?>
