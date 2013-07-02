<?php
$this->breadcrumbs=array(
	'Acquisition Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AcquisitionRequest','url'=>array('index')),
	array('label'=>'Create AcquisitionRequest','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('acquisition-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Acquisition Requests</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'acquisition-request-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'requested_by',
		'request_date',
		'status',
		'currency_id',
		'vendor_id',
		/*
		'notes',
		'budget_id',
		'library_id',
		'request_mode_id',
		'approved_by',
		'approved_date',
		'rejected_by',
		'rejected_reason',
		'rejected_date',
		'expected_purchase_date',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
