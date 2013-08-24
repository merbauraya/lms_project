<?php

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
		'title' => "Manage Acquisition Request",
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
	'id'=>'acquisition-request-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		array('header'=>'Requested By',
              'value'=>'$data->requestedBy->name',
              'name'=>'requested_by'),
		'request_date',
		array('name'=>'status_id',
			  'header'=>'Status',
			  'value'=>'Lookup::item("REQUEST_STATUS",$data->status_id)',
			  'filter'=>Lookup::items('REQUEST_STATUS'),
		
		),

        
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
<?php $this->endWidget() ?>
