<?php  
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => 'Renew ',
		//'headerIcon' => 'icon-user',
		'content' => $this->renderPartial('_renewalform',array('model'=>$model),true),
	));
	
	
	$this->endWidget();
?>

