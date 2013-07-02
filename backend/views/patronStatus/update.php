<?php
$this->breadcrumbs=array(
	'Patron Statuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PatronStatus','url'=>array('index')),
	array('label'=>'Create PatronStatus','url'=>array('create')),
	array('label'=>'View PatronStatus','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PatronStatus','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Patron Status",
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
								array('label'=>'List','url'=>array('index',)),
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php

	$this->endWidget();

?>