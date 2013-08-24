<?php

$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Acquisition Request",
		//'headerIcon' => 'icon-user',
		'content' => '',
        'id'=>'request-box',
	));
	
?>
<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
	$summary = $this->renderPartial('_form',array('model'=>$model),true);
	$item = $this->renderPartial('_form_item_suggestion',array('model'=>$model,'items'=>$items,'sID'=>$model->id,'suggModel'=>$suggModel),true);
	$requestItem = $this->renderPartial('_form_item',array('sID'=>$model->id,'itemDP'=>$itemDP),true);
$this->beginWidget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>array(
		array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
		array('label'=>'Suggestion Items', 'content'=>$item),
		array('label'=>'Item Entry', 'content'=>$requestItem),
		array('label'=>'Notes', 'content'=>$this->renderPartial('_note',array('model'=>$model),true)),
	),
));

$this->endWidget(); //form
$this->endWidget(); //lmbox
?>

<script type="text/javascript">
 function updateItem()
    {
        // public property
        var _updateItem_url;
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            url : updateItem._updateItem_url,
            'success': function(data){
                if (data.status == 'failure')
                {
                    $('#item-lmDialog div.divForForm').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#item-lmDialog div.divForForm form').submit(updateItem);
                }
                else
                {
                    $('#item-lmDialog div.divItem_').html(data.div);
                    setTimeout("$('#item-lmDialog').dialog('close') ",2000);
 
                    // Refresh the grid with the update
                    $.fn.yiiGridView.update('grid_acq_request_item');
                }                
            
            }
        
    
        });
        return false;
 
    }
    function batchSuggApprove(values)
    {
       var _request_id = $('#request_id').val();
       var ids = new Array();
        if(values.size()>0){
             values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
            type: 'POST',
            url: '/acquisitionRequest/promoteSuggestion',
            data: {'ids': ids,rid: _request_id},
      
            dataType:'json',
            success: function(data){
                //alert( 'Data Saved: ' + resp);
                $.lmNotify(data);
                if(data.status == 'success')
                {
                   $.fn.yiiGridView.update('grid_sugg_items');
                  $.fn.yiiGridView.update('grid_acq_request_item');
                }
            }
        });
        
        }
    
        
        
        
        
    }

</script>
<?php
Yii::app()->clientScript->registerScript('__request_',"
$(function(){
        
        $(document).on('click','#grid_sugg_items a.bulk-action',function() {
            return false;
        });
    });
    function batchReject(values){
        
        var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '/acquisitionRequest/rejectItem',
                data: {'ids':ids},
                dataType:'json',
                success: function(data){
                    //alert( 'Data Saved: ' + resp);
					$.lmNotify(data);
                    if(data.status == 'success'){
						$.fn.yiiGridView.update('grid_acq_request_item');
						}
                }
            });
        }
    }
    function batchDelete(values){
        
        var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '/acquisitionRequest/deleteItem',
                data: {'ids':ids},
                dataType:'json',
                success: function(data){
                    
					$.lmNotify(data);
                    if(data.status == 'success'){
						$.fn.yiiGridView.update('grid_acq_request_item');
						}
                }
            });
        }
    }
	
	function batchApprove(values){
        
        var ids = new Array();
        if(values.size()>0){
            values.each(function(idx){
                ids.push($(this).val());
            });
            $.ajax({
                type: 'POST',
                url: '/acquisitionRequest/approveItem',
                data: {'ids':ids},
                dataType:'json',
                success: function(data){
                    //alert( 'Data Saved: ' + resp);
					$.lmNotify(data);
                    if(data.status == 'success'){
						$.fn.yiiGridView.update('grid_acq_request_item');
						}
                }
            });
        }
    }
    
 
    

",CClientScript::POS_BEGIN);


?>
