<?php
    /**
     * view.php
     * Render catalog view
     * 
     * TODO
     *  1. add item/accession info
     */ 


$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Catalog ". $model->id,
		//'headerIcon' => 'icon-user',
		'content' => '',
	));


    $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'id','label'=>'Id'),
		array('name'=>'author_100a','label'=>'Author'),
		array('name'=>'title_245a','label'=>'Title'),
		array('name'=>'isbn_10','label'=>'ISBN'),
		array('name'=>'issn','label'=>'ISSN'),
		'date_created',
		'source',
		'approved_by',
	),
)); ?>

<?php
    $this->endWidget('extcommon.lmwidget.LmBox')
?>    
