<?php 
$this->breadcrumbs=array(
	'View Acquisition Suggestions',
);

$this->menu=array(
	array('label'=>'Create Acquisition Request','url'=>array('create')),
	array('label'=>'Manage Acquisition Request','url'=>array('admin')),
);
?>

<?php


$this->renderPartial('//AcquisitionSuggestion/_suggestionlist',array(
		'status'=>$status));
?>