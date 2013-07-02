<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseOrder','url'=>array('index')),
	array('label'=>'Manage PurchaseOrder','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Purchase Order",
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

<?php echo $this->renderPartial('_form', array('model'=>$model,'vendorDP'=>$vendorDP)); 
	$this->endWidget();

?>
