<?php
$this->breadcrumbs=array(
	'Budget Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BudgetTransaction','url'=>array('index')),
	array('label'=>'Create BudgetTransaction','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('budget-transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Budget Transaction",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'New Transaction','url'=>array('create')),
								array('label'=>'List','url'=>array('index',)),
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>
<div style="padding:10px;">
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'budget-transaction-grid',
	'type'=>array('condensed','stripped'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'budget_account_id',
		'library_id',
		'trans_code',
		'trans_date',
		'trans_amount',
		/*
		'date_created',
		'created_by',
		'budget_source_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); 

	$this->endWidget();
?>
