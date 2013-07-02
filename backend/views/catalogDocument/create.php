<?php
$this->breadcrumbs=array(
	'Catalog Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CatalogDocument','url'=>array('index')),
	array('label'=>'Manage CatalogDocument','url'=>array('admin')),
);
?>

<h1>Create CatalogDocument</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'modelCatalog'=>$modelCatalog)); ?>