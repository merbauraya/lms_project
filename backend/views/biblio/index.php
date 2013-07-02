<?php
$this->breadcrumbs=array(
	'Biblios',
);

require_once('_sidemenu.php');
?>

<h1>Biblios</h1>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'fixedHeader' => true,
	'headerOffset' => 40, 
	'id'=>'biblio-grid',
	'responsiveTable'=>true,
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered',
	'filter'=>$model,
	'columns'=>array(
		
		'title',
		'isbn_issn',
		
		'date_updated',
		'edition',
		/*
		'language_id',
		'publisher_id',
		'call_number',
		'publish_year',
		'collation',
		'classification',
		'cover_image',
		'opac_show',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
