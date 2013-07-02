<?php
$this->breadcrumbs=array(
	'Catalog Documents'=>array('index'),
	$model->catalog_id,
);

$this->menu=array(
	array('label'=>'List CatalogDocument','url'=>array('index')),
	array('label'=>'Create CatalogDocument','url'=>array('create')),
	array('label'=>'Update CatalogDocument','url'=>array('update','id'=>$model->catalog_id)),
	array('label'=>'Delete CatalogDocument','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->catalog_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogDocument','url'=>array('admin')),
);
?>

<h1>View CatalogDocument #<?php echo $model->catalog_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'catalog_id',
		'accession_number',
		'library_id',
		'location_id',
		'barcode',
		'book_number',
		'classification_number',
		'call_number',
		'document_status_id',
		'category_id',
		'control_number',
	),
)); ?>
