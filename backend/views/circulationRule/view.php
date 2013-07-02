<?php
$this->breadcrumbs=array(
	'Circulation Rules'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CirculationRule','url'=>array('index')),
	array('label'=>'Create CirculationRule','url'=>array('create')),
	array('label'=>'Update CirculationRule','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete CirculationRule','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CirculationRule','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Circulation Rule",
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
		'library_id',
		'patron_category_id',
		'smd_id',
		'item_category_id',
		'loan_period',
		'item_count_limit',
		'period_type',
		'fine_per_period',
		'max_renewal_count',
	),
)); ?>

<?php $this->endWidget();?>