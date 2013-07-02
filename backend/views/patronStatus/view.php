<?php
$this->breadcrumbs=array(
	'Patron Statuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PatronStatus','url'=>array('index')),
	array('label'=>'Create PatronStatus','url'=>array('create')),
	array('label'=>'Update PatronStatus','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PatronStatus','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PatronStatus','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Patron Status",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin',)),
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
		'allow_checkout',
		'allow_checkin',
		'allow_reserve',
		'allow_backend_login',
		'allow_opac_login',
		'allow_renew',
		'allow_comment',
	),
)); ?>

<?php

	$this->endWidget();

?>
