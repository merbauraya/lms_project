<?php /*
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Delete',
	'size' => 'medium',
	'icon' =>'icon-trash',
	'htmlOptions'=>array('class'=>'deleteall-button','name'=>'btndeleteall')
)); */ ?>
<div id="statusMsg"></div>

<?php 
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_acq_request_item',
	'selectableRows' => '2',
	'dataProvider'=>$itemDP,
	'template'=>"{items}\n{pager}",
	'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'link',
				'type' => 'primary',
				'size' => 'small',
				'label' => 'Approve Item',
				'click' => 'js:batchApprove',
				'htmlOptions'=>array('class'=>'bulk-action'),
				),
			array(
				'buttonType' => 'link',
				'type' => 'warning',
				'size' => 'small',
				'label' => 'Reject Item',
				'click' => 'js:batchReject',
				'htmlOptions'=>array('class'=>'bulk-action'),
			),	
			array(
				'buttonType' => 'link',
				'type' => 'danger',
				'size' => 'small',
				'label' => 'Delete Item',
				'icon'=> 'icon-trash',
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
		array('name'=>'status_id',
			  'header'=>'Status',
			  'value'=>'Lookup::item("REQUEST_STATUS",$data->status_id)',
			  'filter'=>Lookup::items('REQUEST_STATUS'),
		
		),

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
                $("#item-lmDialog").dialog("open");}\'
            )
        );',
),
	),
));

?>

<?php
$deleteURL = Yii::app()->createUrl('acquisitionRequest/deleteItem');
$approveURL = Yii::app()->createUrl('acquisitionRequest/approveitem');
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



	
");

?>
<?php
$newItemUrl = Yii::app()->createUrl("acquisitionRequest/createItem") . $sID;
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
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'item-lmDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Suggestion Item',
        'autoOpen'=>false,
        'width'=>'600',
		'height'=>'520',
        
        'modal'=>true,
        'resizable'=>false,
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
<?php
Yii::app()->clientScript->registerScript('__request_',"
    var gridId = 'grid_acq_request_item';
	
	$(function(){
        // prevent the click event
        $(document).on('click','#grid_acq_request_item a.bulk-action',function() {
            return false;
        });
    
    });
    
    
   
 
    

",CClientScript::POS_BEGIN);


?>



 
 


