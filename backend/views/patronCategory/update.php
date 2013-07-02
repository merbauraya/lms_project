<?php
$this->breadcrumbs=array(
	'Patron Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PatronCategory','url'=>array('index')),
	array('label'=>'Create PatronCategory','url'=>array('create')),
	array('label'=>'View PatronCategory','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PatronCategory','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Patron Category",
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
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>

<?php $this->endWidget();?>