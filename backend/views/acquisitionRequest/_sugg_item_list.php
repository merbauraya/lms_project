<?php
//Promote selected suggestion to request
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Promote To Request',
	'size' => 'medium',
	'icon' =>'icon-trash',
	'htmlOptions'=>array('class'=>'suggestion_action','name'=>'btnpromotell',
		'id'=>'btn_promote_sugg')
));  ?>
<?php
//reject selected suggestion 

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Reject Suggestion',
	'size' => 'medium',
	'icon' =>'icon-trash',
	'htmlOptions'=>array('class'=>'suggestion_action',
		'id'=>'btn_reject_sugg')
));  

?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<?php
  $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_sugg_items',
	'selectableRows' => '2',
	'dataProvider'=>$itemsDP,
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
                array('name'=>'isbn','header'=>'ISBN','value'=>'$data->isbn'),
		array('name'=>'title','header'=>'Title'),
		
		array('name'=>'publisher','header'=>'Publisher'),
		/*
		array(
            'class'=>'DataColumn',
            'name'=>'suggest_date',
			'header'=> 'Date',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('id'=>'"{$data->id}"'),
        ), */
array(

    'header'=>'Action',
    'type'=>'raw',
    'value'=>'CHtml::link(
        "Update",
        "",
        array(
            \'style\'=>\'cursor: pointer; text-decoration: underline;\',
            \'onclick\'=>\'{
                updateItem._updateItem_url="\'.
                    Yii::app()->createUrl(
                        "acquisitionSuggestion/updateItem",
                        array("id"=>$data["id"])
                    )
                .\'";
                updateItem();
                $("#itemDialog").dialog("open");}\'
            )
        );',
),
	),
));

?>


<?php $this->endWidget(); ?>
<?php
//todo : merge these two functions below

$promoteUrl = Yii::app()->createUrl('acquisitionrequest/promoteSuggestion');
$rejectUrl =  Yii::app()->createUrl('acquisitionrequest/rejectSuggestion');
Yii::app()->clientScript->registerScript('sc_promote_sugg_item', "

$('#btn_promote_sugg').live('click',function(){

        var th=this;
        var afterDelete=function(link,success,data){ if(success) $(\"#statusMsg\").html(data); };
        var _selectionIds = $.fn.yiiGridView.getSelection(\"grid_sugg_items\");
		//get selected request and pass it to ajax request
		var _request_id = $('#request_id').val();	
        if (_selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"grid_sugg_items\", {
                        type:\"POST\",
                        url:\"$promoteUrl\",
                        data: {ids: _selectionIds,rid: _request_id},
                        dataType: \"text\",
                        success:function(data) {
                        $.fn.yiiGridView.update(\"grid_sugg_items\");
						$.fn.yiiGridView.update(\"grid_req_items\");
                        afterDelete(th,true,data);
                        },
                        error:function(XHR) {
                        return afterDelete(th,false,XHR);
                        }
                        });

        }else

        {
             alert('Please select at least one item');

        }
        return false;


});

$('#btn_reject_sugg').live('click',function(){

        var th=this;
        var afterDelete=function(link,success,data){ if(success) $(\"#statusMsg\").html(data); };
        var _selectionIds = $.fn.yiiGridView.getSelection(\"grid_sugg_items\");
		//get selected request and pass it to ajax request
		var _request_id = $('#request_id').val();	
        if (_selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"grid_sugg_items\", {
                        type:\"POST\",
                        url:\"$rejectUrl\",
                        data: {ids: _selectionIds,rid: _request_id},
                        dataType: \"text\",
                        success:function(data) {
                        $.fn.yiiGridView.update(\"grid_sugg_items\");
                        afterDelete(th,true,data);
                        },
                        error:function(XHR) {
                        return afterDelete(th,false,XHR);
                        }
                        });

        }else

        {
             alert('Please select at least one item');

        }
        return false;


});

");

?>



