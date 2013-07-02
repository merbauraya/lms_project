<?php
$this->breadcrumbs=array(
	'Acquisition Suggestion Vendor Rfqs',
);

$this->menu=array(
	array('label'=>'Create AcquisitionSuggestionVendorRFQ','url'=>array('create')),
	array('label'=>'Manage AcquisitionSuggestionVendorRFQ','url'=>array('admin')),
);
?>

<h1>Acquisition Suggestion Vendor Rfqs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
