<?php
$this->breadcrumbs=array(
	'Budget Transaction Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BudgetTransactionType','url'=>array('index')),
	array('label'=>'Manage BudgetTransactionType','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Budget Transaction Type",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget();?>