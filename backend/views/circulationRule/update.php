<?php
$this->breadcrumbs=array(
	'Circulation Rules'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CirculationRule','url'=>array('index')),
	array('label'=>'Create CirculationRule','url'=>array('create')),
	array('label'=>'View CirculationRule','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage CirculationRule','url'=>array('admin')),
);
?>
<div class="clearfix"></div>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Update Patron Category",
		//'headerIcon' => 'icon-user',
		'content' => '',
        'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'List','url'=>array('index',)),
								array('label'=>'Create','url'=>array('create',)),
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form2',array('model'=>$model)); ?>
<?php $this->endWidget();?>
