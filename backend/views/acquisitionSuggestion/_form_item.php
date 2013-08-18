<?php

$newItemUrl = Yii::app()->createUrl("acquisitionSuggestion/createItem") . $sID;
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'New',
	'size' => 'medium',
	'icon' => 'icon-plus-sign',
	'htmlOptions' =>array(
        'class' =>'item_new',
        'onclick'=>'{
              updateItem._updateItem_url="' .$newItemUrl .'";
              updateItem();
              $("#item-lmDialog").dialog("open");
          
        }'
        )
));

echo '&nbsp;';
?>
<div id="statusMsg"></div>

<?php 
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'acq_suggestion_item',
	'selectableRows' => '2',
	'dataProvider'=>$itemDP,
	'template'=>"{items}\n{pager}",
      'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'type' => 'danger',
				'size' => 'small',
				'label' => 'Delete',
                'icon' =>'icon-trash',
				'click' => 'js:batchDelete',
                
				'htmlOptions'=>array('class'=>'bulk-action'),
				),
	
            ),
	
			'checkBoxColumnConfig' => array(
				'name' => 'id'
			),
        ),
	'columns'=>array(
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
        array('name'=>'isbn','header'=>'ISBN','value'=>'$data->isbn'),
		array('name'=>'title','header'=>'Title'),
		array('name'=>'publisher','header'=>'Publisher'),
		array('name'=>'local_price'),
        array('header'=>'Quantity','name'=>'number_of_copy'),
        array('header'=>'Total','value'=>'$data->local_price * $data->number_of_copy'),
        
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
                $("#item-lmDialog").dialog("open");}\'
            )
        );',
),
	),
));

?>

<?php
$deleteURL = Yii::app()->createUrl('acquisitionSuggestion/deleteItem');
Yii::app()->clientScript->registerScript('ajaxupdate', "
$('#acq_suggestion_item a.ajaxupdate').live('click', function() {
		
		var params = $(this).parent().parent().parent().parent().attr('id');
		console.log($(this).text());
		if ($(this).text()=='Update')
		{
                console.log($(this).attr('href')+ params);
		}
		if ($(this).text()=='Edit')
		{
			window.location = $(this).attr('href')+ params;
			console.log(window.location);
			return false;
		}
                console.log($(this).attr('href')+ params);
		$.fn.yiiGridView.update('acq_suggestion_item', {
                type: 'POST',
                url: $(this).attr('href')+ params ,

		success: function(data) {
                        $.fn.yiiGridView.update('acq_suggestion_item');
                }
        });
		
		//var rid = $(this).parent().parent().parent().parent().attr('id');
		//alert(rid);
        return false;
});

function batchDelete(values)
{
    var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '/acquisitionSuggestion/DeleteItem',
                data: {'ids':ids},
                dataType:'json',
                success: function(data){
                    
					$.lmNotify(data);
                    if(data.status == 'success'){
						$.fn.yiiGridView.update('acq_suggestion_item');
						}
                }
            });
        }
}
$('.deleteall-button').click(function(){

         var th=this;
         var afterDelete=function(link,success,data){ if(success) $(\"#statusMsg\").html(data); };
        //var atLeastOneIsChecked = $('input[name=\"acq_suggestion_item_c0[]\"]:checked').length > 0;
        var selectionIds = $.fn.yiiGridView.getSelection(\"acq_suggestion_item\");

        if (selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"acq_suggestion_item\", {
                        type:\"POST\",
                        url:\"$deleteURL\",
                        data: {ids: selectionIds},
                        dataType: \"text\",
                        success:function(data) {
                        $.fn.yiiGridView.update(\"acq_suggestion_item\");
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
<?php
$newItemUrl = Yii::app()->createUrl("acquisitionSuggestion/createItem") . $sID;
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'New',
	'size' => 'medium',
	'icon' => 'icon-plus-sign',
	'htmlOptions' =>array(
        'class' =>'item_new',
        'onclick'=>'{
              updateItem._updateItem_url="' .$newItemUrl .'";
              updateItem();
              $("#item-lmDialog").dialog("open");
          
        }'
        )
));
?>
&nbsp




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'item-lmDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Suggestion Item',
        'autoOpen'=>false,
        'width'=>'590',
		'height'=>'480',
        'resizable'=>false,
        'modal'=>true,
    ),
));
	//$itemModel = new AcquisitionSuggestionItem();
	//$itemModel->acq_suggestion_id = $sID;
	//$this->renderPartial('_form_item_popup',array('model'=>$itemModel,'sID'=>$sID));
?>
<div class="divForForm"></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
 
function updateItem()
{
    // public property
    var _updateItem_url;
	var _form;
	var _div;

    updateItem._div = 'divForForm';
    <?php echo CHtml::ajax(array(
        'url'=>'js:updateItem._updateItem_url',
        'data'=> "js:$(this).serialize()",
        'type'=>'post',
        'dataType'=>'json',
        'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
					$('#item-lmDialog div.divForForm').html(data.div);
                    
					// Here is the trick: on submit-> once again this function!
                    $('#item-lmDialog div.divForForm form').submit(updateItem);
                }
                else
                {
                    $.lmNotify(data);
                    //if (data.status =='success')
                        
                    //$('#itemDialog div.divForForm').html(data.div);
					//$('#itemDialog div.divItem_').html(data.div);
                    setTimeout(\"$('#item-lmDialog').dialog('close') \",2000);
 
                    // Refresh the grid with the update
                    $.fn.yiiGridView.update('acq_suggestion_item');
                }
 
        } ",
    ))?>;
    return false;
 
}
 
</script>
 

 
 


