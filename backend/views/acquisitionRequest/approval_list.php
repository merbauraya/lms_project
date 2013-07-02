<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Request Approval List",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
	
	));
	
?>


<?php
/**
* approval_list.php
  Render list of Suggestion Request (for action)
*
**/
?>
<div id="parent_request" style="padding:10px">
<?php 
  $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_acq_request_list',
	'selectableRows' => '2',
	'dataProvider'=>$requestDP,
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
        array('header'=>'Requested By','value'=>'$data->patron->name'),
		array('header'=>'Faculty','value'=>'$data->patron->department->name'),
		array('name'=>'request_date','header'=>'Request Date'),
		//array('name'=>'publisher','header'=>'Publisher'),
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
                        "acquisitionRequest/updateItem",
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


<?php
/* we provide button for user to load request item based on selected request
*/
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Load Item',
	'type' => 'primary',
	'size' => 'medium',
	'icon' => 'icon-refresh',
	'htmlOptions' => array('id'=>'_btn_load_req_items',),
));

?>
<p id="loadingPic"></br></p>

<div class="item_btn_action" style="visibility:hidden">
<?php
//Promote selected suggestion to request
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Approve',
	'size' => 'medium',
	'icon' =>'icon-check',
	'htmlOptions'=>array('class'=>'requestitem_action',
		'id'=>'btn_approve_request')
));  ?>
<?php
//reject selected suggestion 

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Reject',
	'size' => 'medium',
	'icon' =>'icon-remove-circle',
	'htmlOptions'=>array('class'=>'requestitem_action',
		'id'=>'btn_reject_request')
));  

?>
</div>

<div id="div_request_items">
<?php
  $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_req_items',
	'selectableRows' => '2',
	'dataProvider'=>$itemModel->searchNewItemByRequestId($parentID),
	'filter'=>$itemModel,
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
</div>
<div class="item_btn_action" style="visibility:hidden">
<?php
//Promote selected suggestion to request
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Approve',
	'size' => 'medium',
	'icon' =>'icon-check',
	'htmlOptions'=>array('class'=>'requestitem_action',
		'id'=>'btn_approve_request')
));  ?>
<?php
//reject selected suggestion 

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Reject',
	'size' => 'medium',
	'icon' =>'icon-remove-circle',
	'htmlOptions'=>array('class'=>'requestitem_action',
		'id'=>'btn_reject_request')
));  

//reject selected suggestion 

$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Reject',
	'size' => 'medium',
	'icon' =>'icon-remove-circle',
	'htmlOptions'=>array('class'=>'requestitem_action',
		'id'=>'btn_on_hold')
));  
?>
</div>
</div>
<?php
$_url = Yii::app()->createUrl('acquisitionrequest/loadRequestItem');
Yii::app()->clientScript->registerScript('sc_load_req_item',"
$('body').on('click','#_btn_load_req_items',function(){

var _url = '" . $_url ."' ;
var _selectedSuggestion = $.fn.yiiGridView.getSelection(\"grid_acq_request_list\");
if (_selectedSuggestion.length==0)
{
	alert('Please select at least one request');
	return false;
}		
 /*Display the loading.gif file via jquery and CSS*/
     $('#loadingPic').addClass('ajax_loading');
	 $('.item_btn_action').css('visibility', 'hidden');

var request = $.ajax({
	
	url : _url,
	data : {ids: _selectedSuggestion},
	dataType: \"text\",
	type : \"POST\",
	cache : false
	});
	
	request.done(function(response) {
		try
		{
			if (response.indexOf('<script') == -1)
			{
				$('#div_request_items').html(response);	
			}
			else
			{
				throw new Error('Invalid script in response');
			}
		}catch (ex)
		{
			 console.log(ex.message); /*** Send this to the server for
                 logging when in production ***/	
		}
		finally
		{
			$('#loadingPic').removeClass('ajax_loading');
			$('.item_btn_action').css('visibility', 'visible');
		}
	}); 
	
	request.fail(function(jqXHR, textStatus) 
		{
		 try{
                throw new Error('Request failed: ' + textStatus );
            }
            catch (ex)
			{
                console.log(ex.message); /*** Send this to the server for
                 logging when in production ***/
            }
            finally
			{
                /*Remove the loading.gif file via jquery and CSS*/
                $('#loadingPic').removeClass('ajax-loading');
 
                
			}
		
	});
	
		
	return false;	
});

");
?>
<?php
//todo : merge these two functions below

$approveUrl = Yii::app()->createUrl('acquisitionrequest/approveItem');
$rejectUrl =  Yii::app()->createUrl('acquisitionrequest/rejectItem');
Yii::app()->clientScript->registerScript('sc_action_request_item', "

$('.requestitem_action').live('click',function(){

        var th=this;
		var actionUrl = \"$approveUrl\";
		if (this.id == \"btn_reject_request\")
			actionUrl = \"$rejectUrl\";
		
        var afterDelete=function(link,success,data){ if(success) $(\"#statusMsg\").html(data); };
        var _selectionIds = $.fn.yiiGridView.getSelection(\"grid_req_items\");
		//get selected request and pass it to ajax request
		//var _request_id = $('#request_id').val();	
        if (_selectionIds.length!==0)
        {
           $.fn.yiiGridView.update(\"grid_req_items\", {
                        type:\"POST\",
                        url: actionUrl,
                        data: {ids: _selectionIds},
                        dataType: \"text\",
                        success:function(data) {
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


");

?>
<?php $this->endWidget();?>