<?php
$this->breadcrumbs=array(
	'Patron Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PatronCategory','url'=>array('index')),
	array('label'=>'Manage PatronCategory','url'=>array('admin')),
);
?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Patron Category",
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
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();
?>
