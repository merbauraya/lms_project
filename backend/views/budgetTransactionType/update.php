<?php
$this->breadcrumbs=array(
	'Budget Transaction Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetTransactionType','url'=>array('index')),
	array('label'=>'Create BudgetTransactionType','url'=>array('create')),
	array('label'=>'View BudgetTransactionType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BudgetTransactionType','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Budget Transaction Type",
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
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); 
	$this->endWidget();
?>
