<?php
$this->widget('zii.widgets.jui.CJuiAccordion', array(
	'panels'=>array(
		'New Arrival'=>$this->renderPartial('_new_arrival',null,true),
		'Library News'=>'content for library news',
		// panel 3 contains the content rendered by a partial view
		// 'panel 3'=>$this->renderPartial('_partial',null,true),
		'Campus News'=>'content for campus news',
		
	),
	// additional javascript options for the accordion plugin
	'options'=>array(
		'animated'=>'bounceslide',
		'heightStyle'=>'content',
	),
	
));

?>