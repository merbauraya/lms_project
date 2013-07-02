<?php
$this->breadcrumbs=array(
	'Acquisition Suggestions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AcquisitionSuggestion','url'=>array('index')),
	array('label'=>'Create AcquisitionSuggestion','url'=>array('create')),
	array('label'=>'Update AcquisitionSuggestion','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete AcquisitionSuggestion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AcquisitionSuggestion','url'=>array('admin')),
);
?>

<h1>View AcquisitionSuggestion #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'suggested_by',
		
		'notes',
		'budget_id',
		'library_id',
	),
)); ?>
