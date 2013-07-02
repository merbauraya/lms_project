<?php
$this->breadcrumbs=array(
	'Biblios'=>array('index'),
	'Create',
);
require_once('_sidemenu.php'); /*
$this->menu=array(
	array('label'=>'List Biblio','url'=>array('index')),
	array('label'=>'Manage Biblio','url'=>array('admin')),
);*/
?>

<h6 class="form-title">Create Biblio</h6>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>