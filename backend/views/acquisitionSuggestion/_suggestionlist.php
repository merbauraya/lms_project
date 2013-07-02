<div class="generic_widget">
<?php


$model = new AcquisitionSuggestion;
if ($status!=0)
	$model->status=$status;
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'acq_suggestion_grid',
	'dataProvider'=>$model->search(),
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'suggested_by','header'=>'Suggested By','value'=>'$data->patron->name'),
		array('name'=>'suggest_date','header'=>'Date'),
		
		array('name'=>'budget_id','header'=>'Budget','value'=>'$data->budget->name'),
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
       array('label'=>'Promoted', 
	   		'url'=>Yii::app()->controller->createUrl("AcquisitionSuggestion/Promote"),
	   	'linkOptions'=>array('class'=>'ajaxupdate'),
		
		),
		 array('label'=>'Update', 
	   		'url'=>Yii::app()->controller->createUrl("AcquisitionSuggestion/update"),
	   	'linkOptions'=>array('class'=>'ajaxupdate'),
		
		),
		

       array('label'=>'Rejected', 'url'=>
	   	   		Yii::app()->controller->createUrl("AcquisitionSuggestion/Reject"),
					'linkOptions'=>array('class'=>'ajaxupdate'),
	   ),
       array('label'=>'Keep in View', 'url'=>'#'),
       '---',
       array('label'=>'Delete', 'url'=>Yii::app()->controller->createUrl("AcquisitionSuggestion/delete"),'linkOptions'=>array('class'=>'ajaxupdate')),
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
Yii::app()->clientScript->registerScript('ajaxupdate', "
$('#acq_suggestion_grid a.ajaxupdate').live('click', function() {
		
		var params = $(this).parent().parent().parent().parent().attr('id');
		console.log($(this).text());
		if ($(this).text()=='Update')
		{
			window.location = $(this).attr('href')+ params;
			console.log(window.location);
			return false;
		}
		
        
		$.fn.yiiGridView.update('acq_suggestion_grid', {
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