<?php
$this->breadcrumbs=array(
	'Patron Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PatronCategory','url'=>array('index')),
	array('label'=>'Create PatronCategory','url'=>array('create')),
	array('label'=>'Update PatronCategory','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PatronCategory','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PatronCategory','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Patron Category",
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
		'date_created',
		'date_modified',
		'library_id',
		'is_active',
	),
)); 

	$this->endWidget();
?>
