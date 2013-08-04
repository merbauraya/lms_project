
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'library_id',
		'patron_category_id',
		'username',
		'password',
		'email',
		'phone1',
		'phone2',
	),
)); ?>
