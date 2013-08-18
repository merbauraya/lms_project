
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Budget Account",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButtonGroup',
			   'buttons' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'List','url'=>array('index')),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>

<?php 
	echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();
?>
