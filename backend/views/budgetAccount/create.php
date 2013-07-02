<?php
$this->breadcrumbs=array(
	'Budget Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BudgetAccount','url'=>array('index')),
	array('label'=>'Manage BudgetAccount','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Budget Account",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButtonGroup',
			   'buttons' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'List','url'=>array('index')),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php 
	echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();
?>
