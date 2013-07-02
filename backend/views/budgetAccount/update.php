<?php
$this->breadcrumbs=array(
	'Budget Accounts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetAccount','url'=>array('index')),
	array('label'=>'Create BudgetAccount','url'=>array('create')),
	array('label'=>'View BudgetAccount','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BudgetAccount','url'=>array('admin')),
);
?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Budget Account : {$model->budget_code}",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create')),
								array('label'=>'Update','url'=>array('update','id'=>$model->id)),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); 
	$this->endWidget();
?>