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

<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Budget Transaction",
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
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();

?>
