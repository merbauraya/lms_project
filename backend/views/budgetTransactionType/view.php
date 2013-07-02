<?php
$this->breadcrumbs=array(
	'Budget Transaction Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BudgetTransactionType','url'=>array('index')),
	array('label'=>'Create BudgetTransactionType','url'=>array('create')),
	array('label'=>'Update BudgetTransactionType','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BudgetTransactionType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetTransactionType','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Budget Transaction Type",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'List','url'=>array('admin')),
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create')),
			   
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
		'code',
		'name',
		'is_active',
		'user_editable',
	),
)); 

	$this->endWidget();//lmbox
?>
