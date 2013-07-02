<?php
$this->breadcrumbs=array(
	'Budget Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BudgetAccount','url'=>array('index')),
	array('label'=>'Create BudgetAccount','url'=>array('createAccount')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('budget-account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Budget Account",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<div style="padding:10px">	
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn btn-primary')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'budget-account-grid',
	'type'=>'striped condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'budget_code',
		'name',
		'start_date',
		'end_date',
		'is_active',
		//'date_created',
		/*
		'created_by',
		'library_id',
		'dept_id',
		
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
<?php $this->endWidget() ?>