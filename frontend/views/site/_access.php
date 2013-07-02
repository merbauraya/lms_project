<?php
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Public', 'content'=>'Public Content', 'active'=>true),
		array('label'=>'Student', 'content'=>'Student Content'),
		array('label'=>'Staff', 'content'=>'Staff Content'),
		array('label'=>'Administrator', 'content'=>'Admin Content'),
	),
));
	
?>