<?php
	
	$this->widget('bootstrap.widgets.TbDetailView', array(
    'data'=>$data,
    'attributes'=>array(
	    array('name'=>'title', 'label'=>'Main Title'),
		array('name'=>'personal_name','label'=>'Personal Name'),
		array('name'=>'edition','label'=>'Edition'),
		array('name'=>'publish','label'=>'Publish/Created'),
		array('name'=>'physical_info','label'=>'Description'),
	    array('name'=>'isbn','label'=>'ISBN'),
		array('name'=>'note','label'=>'Note'),
		array('name'=>'lc_classification','label'=>'LC classification'),
		array('name'=>'dewey','label'=>'Dewey classification'),
		array('name'=>'geog_code','label'=>'Geographic area code'),
    ),
));
?>