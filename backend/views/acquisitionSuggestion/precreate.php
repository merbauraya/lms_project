
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Acquisition Suggestion",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<?php 
	echo $this->renderPartial('_form', array('model'=>$model)); 
	$this->endWidget();
?>


