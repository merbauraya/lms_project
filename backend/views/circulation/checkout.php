<?php  
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Checkout",
		//'headerIcon' => 'icon-user',
		'content' => $this->renderPartial('_checkoutform',array('model'=>$model),true),
	));
	
	
	$this->endWidget();
?>

