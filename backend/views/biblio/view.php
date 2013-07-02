<?php
$this->breadcrumbs=array(
	'Biblios'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Biblio','url'=>array('index')),
	array('label'=>'Create Biblio','url'=>array('create')),
	array('label'=>'Update Biblio','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Biblio','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Biblio','url'=>array('admin')),
);
?>

<h1>View Biblio #<?php echo $model->id; ?></h1>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'isbn_issn',
		'date_created',
		'date_updated',
		'edition',
		'language_id',
		'publisher_id',
		'call_number',
		'publish_year',
		'collation',
		'classification',
		'cover_image',
		'opac_show',
	),
)); 

?>
