<?php


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

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'circulation-rule-grid',
	'dataProvider'=>$model->getAdminView(),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		//'library_id',
		array('name'=>'smd_name','header'=>'SMD'),
        array('name'=>'patron_category_name','header'=>'Patron Category'),
		
		array('name'=>'item_category_name','header'=>'Item Category'),
		array('header'=>'Loan Period','value'=>array($this,'renderLoadPeriod')),
		
		'item_count_limit',
		
		'max_renewal_count',
        'max_reservation_count',
        'grace_period',
        'fine_per_period',
        'max_fine',
        array('header'=>'Allow Reserve','value'=>'$data->allow_reserve ? "Yes" : "No"'),
        array('header'=>'Hard Due','value'=>array($this,'renderHardDue')),
	
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
<?php $this->endWidget();?>
