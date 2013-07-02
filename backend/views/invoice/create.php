<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Invoice','url'=>array('index')),
	array('label'=>'Manage Invoice','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => $model)); 

?>

<div class="generic_widget">
	<div class="form-wrapper">
		<header role="">
			<h6>Create Invoice</h6>
		</header>
		<div class="partial_form" style="display: block">
			<?php echo $this->renderPartial('_form', array('model'=>$model,'vendorDP'=>$vendorDP,'poDP'=>$poDP)); ?>
		</div>
	</div>		
</div>