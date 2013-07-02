<div class="generic_widget">
<header role="heading">
<h6>Acquisition Request</h6>
</header>
<?php
$model = new AcquisitionRequest ;
//if ($status!=0)
//	$model->status=$status;
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'acq_request_grid',
	'dataProvider'=>$model->search(),
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'title','header'=>'Title'),
		
		array('name'=>'author','header'=>'Author'),
		array('name'=>'isbn_issn','header'=>'ISBN/ISSN'),
		array('name'=>'publisher','header'=>'Publisher'),
		array('name'=>'requested_by','header'=>'By'),
		array('name'=>'budget_id','header'=>'Budget','value'=>'$data->budget->name'),
		array('name'=>'request_date','header'=>'date'),
		/*
		array(
            'class'=>'DataColumn',
            'name'=>'suggest_date',
			'header'=> 'Date',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('id'=>'"{$data->id}"'),
        ), */
		array('header'=>'','type'=>'raw',
		 'class'=>'DataColumn',
            
			'header'=>'Action',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('id'=>'"{$data->id}"'),
		
		'value'=>function (){
			Yii::app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
	'size'=>'medium',
    'type'=>'primary', 
	'buttons'=>array(
       array('label'=>'Action', 'items'=>array(
       array('label'=>'View Details', 
	   		'url'=>Yii::app()->controller->createUrl("AcquisitionRequest/view"),
	   	'linkOptions'=>array('class'=>'itemAction'),
		
		),
		array('label'=>'Edit','icon'=>'icon-plus-sign', 
	   		'url'=>Yii::app()->controller->createUrl("AcquisitionRequest/update"),
	   	'linkOptions'=>array('class'=>'itemAction'),
		
		),
		
		
		

       array('label'=>'Rejected', 'url'=>
	   	   		Yii::app()->controller->createUrl("AcquisitionSuggestion/Reject"),
					'linkOptions'=>array('class'=>'ajaxupdate'),
	   ),
       array('label'=>'Keep in View', 'url'=>'#'),
       '---',
       array('label'=>'Delete', 'url'=>'#'),
    )),
    ),
));
		}
		
			 ),
	),
));

?>
</div>
<?php
Yii::app()->clientScript->registerScript('itemAction', "
$('#acq_request_grid a.itemAction').live('click', function() {
	
		var params = $(this).parent().parent().parent().parent().attr('id');
        window.location = $(this).attr('href')+ params;
		
        return false;
});
");
?>
<?php
Yii::app()->clientScript->registerScript('ajaxupdate', "
$('#acq_request_grid a.ajaxupdate').live('click', function() {
		
		
		var params = $(this).parent().parent().parent().parent().attr('id');
        
		$.fn.yiiGridView.update('acq_request_grid', {
                type: 'POST',
                url: $(this).attr('href')+ params ,
                
				success: function() {
                        $.fn.yiiGridView.update('acq_suggestion_grid');
                }
        });
		
		//var rid = $(this).parent().parent().parent().parent().attr('id');
		//alert(rid);
        return false;
});
");
?>

