
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'po-request-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<?php
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_approved_request',
	'selectableRows' => '2',
	'dataProvider'=>$reqDP,
	'template'=>"{items}\n{pager}",
	'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'link',
				'type' => 'danger',
				'size' => 'small',
				'icon' =>'icon-check',
				'label' => 'Add To Purchase Order',
				'click' => 'js:batchAdd',
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
					
        array('name'=>'isbn','header'=>'ISBN 10','value'=>'$data->isbn'),
		array('name'=>'isbn_13','header'=>'ISBN 13','value'=>'$data->isbn_13'),
		array('name'=>'title','header'=>'Title'),
		array('name'=>'local_price','header'=>'Local Price'),
		
		array('name'=>'acqRequest.department.name','header'=>'Faculty'),
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
<?php
//todo : merge these two functions below

$addToPoUrl = Yii::app()->createUrl('purchaseOrder/addRequestItem');

Yii::app()->clientScript->registerScript('sc_action_addtopo_item', "
	var addUrl = \"$addToPoUrl\";
	var poTextId = \"$poID\";
	var poID = \"$sID\";
	$(function(){
        // prevent the click event
        $(document).on('click','#grid_approved_request a.bulk-action',function() {
            return false;
        });
    });
	
	function batchAdd(values){
        
        var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: addUrl,
                data: {ids:ids, poId : poID, poTextId : poTextId },
                dataType:'json',
                success: function(data){
                    
					$.lmNotify(data);
                    if(data.status == 'success'){
						$.fn.yiiGridView.update('grid_po_item');
						$.fn.yiiGridView.update('grid_approved_request');
					}
                }
            });
        }
    }

$('.requestitem_action').live('click',function(){

        var th=this;
		var actionUrl = \"$addToPoUrl\";
		var poTextId = \"$poID\";
		var poID = \"$sID\";
		
        var afterDelete=function(link,success,data){ if(success) $(\"#statusMsg\").html(data); };
        var _selectionIds = $.fn.yiiGridView.getSelection(\"grid_approved_request\");
		//get selected request and pass it to ajax request
		//var _po_id = $('#request_id').val();	
        if (_selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"grid_approved_request\", {
                        type:\"POST\",
                        url: actionUrl,
                        data: {ids: _selectionIds, poId : poID, poTextId : poTextId },
                        dataType: \"json\",
                        success:function(data) {
                        $.fn.yiiGridView.update(\"grid_approved_request\");
						$.fn.yiiGridView.update(\"grid_po_item\");
						if (data.status=='success')
						{
							
							$.jGrowl(data.message,
							{
								sticky: false,
								theme : 'lm-success',
								life: 5000
							});
						}
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
