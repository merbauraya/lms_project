<?php
$this->breadcrumbs=array(
	'Acquisition Request'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Acquisition Request','url'=>array('index')),
	array('label'=>'Manage Acquisition Request','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Acquisition Request",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
	$summary = $this->renderPartial('_form',array('model'=>$model),true);
	$item = $this->renderPartial('_form_item_suggestion',array('model'=>$model,'items'=>$items,'sID'=>$model->id,'suggModel'=>$suggModel),true);
	$requestItem = $this->renderPartial('_form_item',array('sID'=>$model->id,'itemDP'=>$itemDP),true);
$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Suggestion Items', 'content'=>$item),
		array('label'=>'Item Entry', 'content'=>$requestItem),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget(); //form
$this->endWidget(); //lmbox
?>


