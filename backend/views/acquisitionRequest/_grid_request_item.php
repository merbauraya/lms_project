<?php
/*
	Render list of request item based on the selected Request

*/

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<?php
  $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_req_items',
	'selectableRows' => '2',
	'dataProvider'=>$itemModel->searchNewItemByRequestId($parentID),
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
        array('name'=>'isbn','header'=>'ISBN 10','value'=>'$data->isbn'),
		array('name'=>'isbn_13','header'=>'ISBN 13','value'=>'$data->isbn_13'),
		array('name'=>'title','header'=>'Title'),
		array('name'=>'local_price','header'=>'Local Price'),
		
		array('name'=>'publisher','header'=>'Publisher'),
		/*
		array(
            'class'=>'DataColumn',
            'name'=>'suggest_date',
			'header'=> 'Date',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('id'=>'"{$data->id}"'),
        ), */

	),
));

?>


<?php $this->endWidget(); ?>
