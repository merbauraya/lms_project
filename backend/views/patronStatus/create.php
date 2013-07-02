<?php
$this->breadcrumbs=array(
	'Patron Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PatronStatus','url'=>array('index')),
	array('label'=>'Manage PatronStatus','url'=>array('admin')),
);
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
								array('label'=>'Manage','url'=>array('admin',)),
								array('label'=>'List','url'=>array('index',)),
								
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php

	$this->endWidget();

?>