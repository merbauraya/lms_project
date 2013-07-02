<?php
$this->breadcrumbs=array(
	'Patrons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Patron','url'=>array('index')),
	array('label'=>'Manage Patron','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Patron",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
	
	));
	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget(); ?>