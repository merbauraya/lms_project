<?php
$this->breadcrumbs=array(
	'Acquisition Request'=>array('index'),
	'Pre Create',
);

$this->menu=array(
	array('label'=>'List Acquisition Request','url'=>array('index')),
	array('label'=>'Manage Acquisition Request','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Acquisition Request",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>

<?php 
	echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();

?>
