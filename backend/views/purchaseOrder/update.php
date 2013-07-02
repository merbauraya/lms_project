<?php
$this->breadcrumbs=array(
	'Purchase Order'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Purchase Order','url'=>array('index')),
	array('label'=>'Manage Purchase Order','url'=>array('admin')),
);
?>

<?php  


$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => $model, 'flash' => 'Model Saved', 'caption' => 'caption')); 

?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Purchase Order",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'List','url'=>array('index')),
								
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>


<?php
	$summary = $this->renderPartial('_form',array('model'=>$model,'vendorDP'=>$vendorDP),true);
	$reqItem = $this->renderPartial('_approved_request_item',array('model'=>$model,'reqDP'=>$reqDP,'poID'=>$model->text_id,'sID'=>$model->id),true,false);
	$poItem = $this->renderPartial('_form_item',array('poID'=>$model->text_id,'sID'=>$model->id,'itemDP'=>$poItemDP,'model'=>$poItemModel),true,false);
$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Approved Request', 'content'=>$reqItem),
		array('label'=>'Purchase Order Item', 'content'=>$poItem),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget();
$this->endWidget();
?>

