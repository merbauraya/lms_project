<?php
//echo $model->po_item_id;

//display catalog summary
//display accounting details ..e.g.budget quantity,cost
//show item detail and allow item edit

$item = $this->renderPartial('_receiveItem',array('model'=>$model,'rID'=>$rID),true);
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Accounting', 'content'=>$item, 'active'=>true),
		array('label'=>'Item Detail', 'content'=>'Item Info'),
		array('label'=>'Catalog', 'content'=>$rID),
),
));


?>