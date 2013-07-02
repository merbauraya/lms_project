<?php  
	//$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Checkin",
		//'headerIcon' => 'icon-user',
		'content' => $this->renderPartial('_checkinform',array('model'=>$model),true),
	));
	
	
	$this->endWidget();
?>

