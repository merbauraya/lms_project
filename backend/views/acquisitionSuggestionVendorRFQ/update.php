<?php
$this->breadcrumbs=array(
	'Acquisition Suggestion Vendor Rfqs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestionVendorRFQ','url'=>array('index')),
	array('label'=>'Create AcquisitionSuggestionVendorRFQ','url'=>array('create')),
	array('label'=>'View AcquisitionSuggestionVendorRFQ','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AcquisitionSuggestionVendorRFQ','url'=>array('admin')),
);
?>

<h1>Update AcquisitionSuggestionVendorRFQ <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>