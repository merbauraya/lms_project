<?php
$this->breadcrumbs=array(
	'Budget Sources'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetSource','url'=>array('index')),
	array('label'=>'Create BudgetSource','url'=>array('create')),
	array('label'=>'View BudgetSource','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage BudgetSource','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Budget Source",
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
								array('label'=>'View','url'=>array('view','id'=>$model->id)),
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); 
	$this->endWidget();
?>