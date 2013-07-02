<?php
$this->breadcrumbs=array(
	'Budget Sources',
);

$this->menu=array(
	array('label'=>'Create BudgetSource','url'=>array('create')),
	array('label'=>'Manage BudgetSource','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Budget Source List",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create',)),
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>
<div style="padding:10px">
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

	
?>
</div>
<?php $this->endWidget(); ?>
