<?php
$this->breadcrumbs=array(
	'Biblios'=>array('index'),
	'Manage',


);
require_once('_sidemenu.php');/*
$this->menu =  array(
			    array('label'=>'Quicklinks', 'itemOptions'=>array('class'=>'nav-header')),
			    array('label'=>'Add Biblio', 'url'=>Yii::app()->controller->createUrl("client/create")),
			    array('label'=>'Create new Quotation', 'url'=>Yii::app()->controller->createUrl("invoice/quote")),
			    array('label'=>'Create New Invoice', 'url'=>Yii::app()->controller->createUrl("invoice/invoice")),
			    array('label'=>'Print Invoice', 'url'=>Yii::app()->controller->createUrl("invoice/selectInvoice")),
				array('label'=>'Another list header', 'itemOptions'=>array('class'=>'nav-header')),
			    array('label'=>'Profile', 'url'=>'#'),
			    array('label'=>'Settings', 'url'=>'#'),
			    
		    );*/
/*
$this->menu=array(
	array('label'=>'List Biblio','url'=>array('index')),
	array('label'=>'Create Biblio','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('biblio-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Biblios</h1>

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
	'id'=>'biblio-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'title',
		'isbn_issn',
		'date_created',
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
