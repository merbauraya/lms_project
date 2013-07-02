<?php
$this->breadcrumbs=array(
	'Acquisition Suggestions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Acquisition Suggestion','url'=>array('index')),
	array('label'=>'Manage Acquisition Suggestion','url'=>array('admin')),
);
?>
<div class="generic_widget">
<div class="form-wrapper">
<header role="">
<h6>Create Acquisition Suggestion RFQ</h6>
</header>
<div style="display: block">
<?php echo $this->renderPartial('_form_vendor_rfq', array('model'=>$model)); ?>
</div>
</div>
</div>