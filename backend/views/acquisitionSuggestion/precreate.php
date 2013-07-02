<?php
$this->breadcrumbs=array(
	'Acquisition Suggestions'=>array('index'),
	'Pre Create',
);

$this->menu=array(
	array('label'=>'List Acquisition Suggestion','url'=>array('index')),
	array('label'=>'Manage Acquisition Suggestion','url'=>array('admin')),
);
?>
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Acquisition Suggestion",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<?php 
	echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();
?>


