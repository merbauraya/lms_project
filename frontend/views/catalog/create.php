<?php
$this->breadcrumbs=array(
	'Catalogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Catalog','url'=>array('index')),
	array('label'=>'Manage Catalog','url'=>array('admin')),
);
?>

<h1>Create Catalog</h1>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); 
?>

<?php

$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs',
	'tabs' => array(
		array('label' => 'Paste', 'items' => array(
			array('label' => 'Marc Data', 'content' => $this->renderPartial('_pasteMARC', array('format'=>'marc'),true)),
			array('label' => 'MarcXML', 'content' => 'Item2 Content')
		)),
		array('label' => 'Template', 'content' => $this->renderPartial('_catalogtemplate', array('format'=>'manual'),true)),
		array('label' => 'Upload', 'items' => array(
			array('label' => 'XML', 'content' => 'Item1 Content'),
			array('label' => 'MARC', 'content' => $this->renderPartial('_uploadMARC', array('t'=>'t'),true)),
		)),
)	)
);
?>

