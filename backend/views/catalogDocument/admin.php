<?php
$this->breadcrumbs=array(
	'Catalog Documents'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CatalogDocument','url'=>array('index')),
	array('label'=>'Create CatalogDocument','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('catalog-document-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Catalog Documents</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'catalog-document-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'catalog_id',
		'accession_number',
		'library_id',
		'location_id',
		'barcode',
		/*
		'book_number',
		'classification_number',
		'call_number',
		'document_status_id',
		'category_id',
		'control_number',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
