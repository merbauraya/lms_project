<?php
$this->breadcrumbs=array(
	'Acquisition Suggestions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestion','url'=>array('index')),
	array('label'=>'Manage AcquisitionSuggestion','url'=>array('admin')),
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
	$summary = $this->renderPartial('_form',array('model'=>$model),true);
	$item = $this->renderPartial('_form_item',array('model'=>$model,'items'=>$items,'sID'=>$model->id,'itemDP'=>$itemDP),true);
$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Items', 'content'=>$item),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget();//tbtabs
$this->endWidget();//lmbox
?>

