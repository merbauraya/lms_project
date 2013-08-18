

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
