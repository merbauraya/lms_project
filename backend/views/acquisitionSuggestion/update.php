<?php
$this->breadcrumbs=array(
	'Acquisition Suggestions'=>array('index'),
	//$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Acquisition Suggestion','url'=>array('index')),
	array('label'=>'Create Acquisition Suggestion','url'=>array('create')),
	array('label'=>'View Acquisition Suggestion','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Acquisition Suggestion','url'=>array('admin')),
);
?>
<div class="generic_widget">
<div class="form-wrapper">
<header role="">
<h6>Create Acquisition Suggestion</h6>
</header>
<div class="partial_form" style="display: block">
<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
	$summary = $this->renderPartial('_form',array('model'=>$model),true);
	//$item = $this->renderPartial('_form_item',array('model'=>$model,'items'=>$items,'sID'=>$model->id),true);
$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Items', 'content'=>$this->renderPartial('_form_item',array('model'=>$model,'itemDP'=>$itemDP,'items'=>$items,'sID'=>$model->id),true)),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget();
?>

</div> <!--partial_form -->
</div> <!--form_wrapper -->
</div> <!-- generic_widget -->