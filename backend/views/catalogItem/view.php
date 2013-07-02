<?php
$this->breadcrumbs=array(
	'Biblio Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BiblioItem','url'=>array('index')),
	array('label'=>'Create BiblioItem','url'=>array('create')),
	array('label'=>'Update BiblioItem','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BiblioItem','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>

<div class="generic_widget">
	<div class="form-wrapper">
		<header role=""><h6>View Accession</h6>
		</header>
		<div style="display:block">

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'accession_number',
		'control_number',
		
		array('label'=>'Category','name'=>'category.name'),
		array('label'=>'Location','name'=>'location.name'),
		
	),
)); ?>
		</div>
	</div>
</div>	