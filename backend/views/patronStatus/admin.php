<?php
$this->breadcrumbs=array(
	'Patron Statuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PatronStatus','url'=>array('index')),
	array('label'=>'Create PatronStatus','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('patron-status-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Patron Status",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'List','url'=>array('index',)),
								array('label'=>'Create','url'=>array('create',)),
								
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
	'id'=>'patron-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'allow_checkout',
		'allow_checkin',
		'allow_reserve',
		'allow_backend_login',
		/*
		'allow_opac_login',
		'allow_renew',
		'allow_comment',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php
	$this->endWidget();
	

?>