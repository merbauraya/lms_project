<?php
$this->breadcrumbs=array(
	'Acquisition Suggestion Vendor Rfqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestionVendorRFQ','url'=>array('index')),
	array('label'=>'Manage AcquisitionSuggestionVendorRFQ','url'=>array('admin')),
);
?>

<h1>Create AcquisitionSuggestionVendorRFQ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>