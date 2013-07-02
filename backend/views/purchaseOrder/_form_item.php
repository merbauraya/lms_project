<div style="padding:10px">
<?php
$newItemUrl = Yii::app()->createUrl("purchaseorder/createItem") . $sID;
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
<?php 
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_po_item',
	'selectableRows' => '2',
	'responsiveTable' => true,
	'fixedHeader' => true,
	'sortableRows'=>true,
	'afterSortableUpdate' => 'js:function(id, position){ console.log("id: "+id+", position:"+position);}',
	'sortableAttribute'=>'item_no',
	'dataProvider'=>$itemDP,
	'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'link',
				'type' => 'danger',
				'size' => 'small',
				'label' => 'Delete Item',
				'click' => 'js:batchDelete',
				'htmlOptions'=>array('class'=>'bulk-action'),
				),
				
		),
	
			'checkBoxColumnConfig' => array(
				'name' => 'id'
			),
	),
	'extendedSummary' => array(
		
		'columns' => array(
		'total_amount' => array('label'=>'Total Amount', 'class'=>'TbSumOperation')
		)
	),
	'extendedSummaryOptions' => array(
		'class' => 'well pull-right',
		'style' => 'width:150px;height:10px;'
	),
	'template'=> '{items}{extendedSummary}',
	'columns'=>array(
	    array('name'=>'item_no','header'=>'#'),
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
                array('name'=>'isbn','header'=>'ISBN','value'=>'$data->isbn'),
		array('name'=>'title','header'=>'Title'),
		
		array('name'=>'publisher','header'=>'Publisher'),
		array('name'=>'local_price','header'=>'Price','htmlOptions'=>array('style' => 'text-align: right;')),
		array('name'=>'quantity','header'=>'Quantity'),
		array('name'=>'total_amount','header'=>'Total','htmlOptions'=>array('style' => 'text-align: right;')),
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
                        "purchaseOrder/updateItem",
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
$deleteURL = Yii::app()->createUrl('purchaseorder/deleteItem');
Yii::app()->clientScript->registerScript('ajaxupdate', "
$('#grid_acq_request_item a.ajaxupdate').live('click', function() {
		
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


$('.po_deleteall-button').click(function(){

         var th=this;
         
		 var afterDelete=function(link,success,data){ if(success) 	  	$(\"#statusMsg\").html(''); 
		 };
        //var atLeastOneIsChecked = //$('input[name=\"grid_po_item_c0[]\"]:checked').length > 0;
        var selectionIds = $.fn.yiiGridView.getSelection(\"grid_po_item\");

        if (selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"grid_po_item\", {
                        type:\"POST\",
                        url:\"$deleteURL\",
                        data: {ids: selectionIds},
                        dataType: \"json\",
                        success:function(data) {
                        $.lmNotify(data);
						$.fn.yiiGridView.update(\"grid_po_item\");
						$.fn.yiiGridView.update(\"grid_approved_request\");
						
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
$newItemUrl = Yii::app()->createUrl("purchaseorder/createItem") . $sID;
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

</div>
 <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'item-lmDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Purchase Order Item',
        'autoOpen'=>false,
        'width'=>'600',
		'height'=>'520',
        'modal'=>true,
		'resizable'=>false
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
	var deleteUrl ="<?php echo Yii::app()->createUrl('purchaseorder/deleteItem') ?>";
	$(function(){
        // prevent the click event
        $(document).on('click','#grid_po_item a.bulk-action',function() {
            return false;
        });
    });
	function batchDelete(values){
        
        var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: {"ids":ids},
                dataType:'json',
                success: function(data){
                    //alert( "Data Saved: " + resp);
					$.lmNotify(data);
                    if(data.status == "success"){
						$.fn.yiiGridView.update('grid_po_item');
						$.fn.yiiGridView.update('grid_approved_request');
					}
                }
            });
        }
    }
	function updateItem()
	{
		// public property
		var _updateItem_url;
	 
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
						$('#item-lmDialog div.divItem_').html(data.div);
						setTimeout(\"$('#item-lmDialog').dialog('close') \",2000);
	 
						// Refresh the grid with the update
						$.fn.yiiGridView.update('grid_po_item');
					}
	 
			} ",
		))?>;
		return false;
	 
	}
 
</script>
 

 
 


