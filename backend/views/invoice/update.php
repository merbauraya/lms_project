<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Create Invoice','url'=>array('create')),
	array('label'=>'View Invoice','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model)); 

?>

<div class="generic_widget">
	<div class="form-wrapper">
		<header role="">
			<h6>Update Invoice : <?php echo $model->invoice_no ?></h6>
		</header>
		<div class="partial_form" style="display: block">
<?php
	$summary = $this->renderPartial('_form',array(
				'model'=>$model,
				'vendorDP'=>$vendorDP,
				'poDP'=>$poDP),true
	); 
	$poItem = $this->renderPartial('_form_po_item',array(
	'model'=>$model,
	'vendorDP'=>$vendorDP,
	'poItemDP'=>$poItemDP),true
	); 
	
	$invItem = $this->renderPartial('_form_inv_item',array(
	'model'=>$model,
	'vendorDP'=>$vendorDP,
	'poDP'=>$poDP),true
	);

$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Purchase Order Item', 'content'=>$poItem),
		array('label'=>'Invoice Item', 'content'=>$invItem),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget();
?>





		</div>
	</div>
</div>
		
