<?php  
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => 'Renew ',
		//'headerIcon' => 'icon-user',
		'content' => $this->renderPartial('_checkinform',array('model'=>$model,'action'=>$action),true),
	));
	
	
	$this->endWidget();
?>

