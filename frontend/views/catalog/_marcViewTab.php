<?php
$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs',
	'tabs' => array(
		array('label' => 'Marc View', 'items' => array(
			array('label' => 'Marc Data', 'content' => $this->renderPartial('_pasteMARC', array('format'=>'marc'),true)),
			array('label' => 'MarcXML', 'content' => 'Item2 Content')
		)),
		array('label' => 'Simple View', 'content' => $this->renderPartial('_catalogtemplate', array('model'=>$model),true)),
		array('label' => 'Upload', 'items' => array(
			array('label' => 'XML', 'content' => 'Item1 Content'),
			array('label' => 'MARC', 'content' => 'Item2 Content')
		)),
	))
);

?>