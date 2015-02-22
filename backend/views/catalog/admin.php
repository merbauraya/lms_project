<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Manage Catalog",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Create','url'=>array('createbytemplate')),
								array('label'=>'List','url'=>array('index',)),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'catalog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'control_number',
        'call_number',
		array('name'=>'title_245a','header'=>'Title'),
		array('name'=>'author_100a','header'=>'Author'),
		array('value'=>'$data->isbn_10."/" .$data->isbn_13','header'=>'ISBN'),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); 
 $this->endWidget();?>
