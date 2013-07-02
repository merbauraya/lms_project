<?php
$this->breadcrumbs=array(
	'Catalog Documents'=>array('index'),
	$model->catalog_id=>array('view','id'=>$model->catalog_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CatalogDocument','url'=>array('index')),
	array('label'=>'Create CatalogDocument','url'=>array('create')),
	array('label'=>'View CatalogDocument','url'=>array('view','id'=>$model->catalog_id)),
	array('label'=>'Manage CatalogDocument','url'=>array('admin')),
);
?>

<h1>Update CatalogDocument <?php echo $model->catalog_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>