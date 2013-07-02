<?php
$this->breadcrumbs=array(
	'Circulation Rules'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CirculationRule','url'=>array('index')),
	array('label'=>'Create CirculationRule','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('circulation-rule-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Circulation Rule",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Create','url'=>array('create')),
								array('label'=>'List','url'=>array('index',)),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

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
	'id'=>'circulation-rule-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'library_id',
		'patron_category_id',
		'smd_id',
		'item_category_id',
		'loan_period',
		/*
		'item_count_limit',
		'period_type',
		'fine_per_period',
		'max_renewal_count',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
<?php $this->endWidget();?>
