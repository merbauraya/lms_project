<?php
$this->breadcrumbs=array(
	'Budget Sources'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BudgetSource','url'=>array('index')),
	array('label'=>'Create BudgetSource','url'=>array('create')),
	array('label'=>'Update BudgetSource','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BudgetSource','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetSource','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Budget Source",
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
								array('label'=>'Create','url'=>array('create',)),
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
		'name',
		array('label'=>'Library','value'=>$model->library->name),
		array('label'=>'Status','value'=>$model->is_active? 'Active':'Inactive'),
		array('label'=>'Created By','value'=>$model->patron->name),
		'date_created',
		'note',
		
	),
)); 

	$this->endWidget();
?>
