<?php
$this->breadcrumbs=array(
	'Patron Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PatronCategory','url'=>array('index')),
	array('label'=>'Create PatronCategory','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('patron-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Patron Category",
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
	'id'=>'patron-category-grid',
	'type'=>array('stripped','bordered','condensed'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'date_created',
		'date_modified',
		'library_id',
		'is_active',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
<?php $this->endWidget();?>
