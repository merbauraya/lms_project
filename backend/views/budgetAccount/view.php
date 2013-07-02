<?php
$this->breadcrumbs=array(
	'Budget Accounts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BudgetAccount','url'=>array('index')),
	array('label'=>'Create BudgetAccount','url'=>array('create')),
	array('label'=>'Update BudgetAccount','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BudgetAccount','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetAccount','url'=>array('admin')),
);
?>

<?php
	//
	//bootstrap.widgets.TbBox'
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Budget Account : {$model->budget_code}",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButtonGroup',
	           'buttons' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create')),
								array('label'=>'Update','url'=>array('update')),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type'=>array('striped','condensed'),
	'attributes'=>array(
		
		'budget_code',
		'name',
		'start_date',
		'end_date',
		'date_created',
		'created_by',
		array('label'=>'Library','value'=>$model->library->name),
		'dept_id',
		'is_active',
	),
)); ?>
<?php $this->endWidget(); ?>