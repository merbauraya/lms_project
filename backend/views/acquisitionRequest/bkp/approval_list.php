<?php
/**
* approval_list.php
  Render list of Suggestion Request (for action)
*
**/
?>
<div id="parent_request">
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
</div>

<?php
/* we provide button for user to load request item based on selected request
*/
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Load Suggestion Item',
	'type' => 'primary',
	'size' => 'medium',
	'htmlOptions' => array('id'=>'_btn_load_req_items',),
));

?>
<p id="loadingPic"></br></p>


<div id="div_request_items">

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
     ('#loadingPic).addClass('ajax_loading');

jQuery.ajax({
	'id' : 'loadSuggItem',
	url : _url,
	data : {ids: _selectedSuggestion},
	dataType: \"text\",
	type : \"POST\",
	cache : false,
	success : function(html)
		{jQuery('#div_request_items').html(html)}});
	
	return false;	
});

");
?>
