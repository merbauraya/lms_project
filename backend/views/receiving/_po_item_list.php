<?php
//Promote selected suggestion to request
/*$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Promote To Request',
	'size' => 'medium',
	'icon' =>'icon-trash',
	'htmlOptions'=>array('class'=>'suggestion_action','name'=>'btnpromotell',
		'id'=>'btn_promote_sugg')
));  */?>
<?php
//reject selected suggestion 
/*
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Reject Suggestion',
	'size' => 'medium',
	'icon' =>'icon-trash',
	'htmlOptions'=>array('class'=>'suggestion_action',
		'id'=>'btn_reject_sugg')
));  
*/
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<?php
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_po_items',
	'selectableRows' => '2',
	'dataProvider'=>$itemsDP,
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		/*array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),*/
        array('name'=>'isbn','header'=>'ISBN','value'=>'$data->isbn'),
		array('name'=>'title','header'=>'Title'),
		
		array('name'=>'publisher','header'=>'Publisher'),
		array('name'=>'quantity','header'=>'Quantity'),
		array('name'=>'price','header'=>'Unit Price'),
		array('header'=>'Total','value'=>'$data->quantity * $data->price'),
		array('name'=>'quantity_received','header'=>'Received'),
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
		"Receive",
		"",
		array(
			\'style\'=>\'cursor: pointer; text-decoration: underline;\',
			\'onclick\'=>\'{receiveItem._sForm=true;
				receiveItem._item_url="\'.
					Yii::app()->createUrl(
					"goodreceive/receiveitem",
					array("id"=>$data["id"])
				)
				.\'";
			receiveItem();
			$("#rcvItemlmDialog").dialog("open");}\'
		)
	);',
),
		array(
			'header'=>'Action',
			'type'=>'raw',
			'value'=>'CHtml::link("Receive",array("receiving/received","pid"=>$data->id))',
			),
		array(
			'header'=>'Action',
			'type'=>'raw',
			'value'=>'CHtml::link(
				"Receive",
				"",
				array(
					\'style\'=>\'cursor: pointer; text-decoration: underline;\',
					\'onclick\'=>\'{
						receiving._item_url="\'.
						Yii::app()->createUrl(
							"receiving/received/",
							array("pid"=>$data["id"])
						)
						.\'";
						receiving();
	
						}\'
					)
			);',
		),

	),
));

?>
<?php $this->endWidget(); ?>
<?php
	//now we show received item
?>
<div id="receivedItem">
	<h6>Received Item</h6>
	<?php
		$this->widget('bootstrap.widgets.TbExtendedGridView', array(
			'type'=>'striped bordered condensed',
			'id'=>'grid_received_item',
			'itemsCssClass'=>'myclass',
			'selectableRows' => '2',
			'dataProvider'=>$rcvdDP,
			'template'=>"{items}\n{pager}",
			'columns'=>array(
				array('header'=>'ISBN','value'=>'$data->orderItem->isbn'),
				array('header'=>'Title','value'=>'$data->orderItem->title'),
				array('name'=>'publisher','header'=>'Publisher','value'=>'$data->orderItem->publisher'),
				array('name'=>'quantity_received','header'=>'# Received'),
				array(
					'header'=>'Action',
					'type'=>'raw',
					'value'=>'CHtml::link(
					"Delete","",
					array(
						\'style\'=>\'cursor: pointer; text-decoration: underline;\',
						\'onclick\'=>\'{receiveItem._sForm=false;
						receiveItem._item_url="\'.
						Yii::app()->createUrl("goodreceive/deleteitem",
										array("id"=>$data["id"])
									)
								.\'";
							receiveItem();
							}\'
						)
					);',
				),
		
			),
		));

	?>	
	
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'rcvItemlmDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Receive Item',
        'autoOpen'=>false,
        'width'=>'600',
		'height'=>'520',
        'modal'=>true,
    ),
));
	
?>
<div class="divForForm"></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php

Yii::app()->clientScript->registerScript('sc_receive_item', "
	
	function receiving()
	{
		var _item_url;	
		var url = receiving._item_url +'&rid='+$rID;
		
		window.location = url;
	}

	function receiveItem()
	{
		
		var _item_url;
		var _sForm; //whether we are loading the popup form
		//if (receiveItem._sForm == null)
		//	receiveItem._sForm = true;
		var url = receiveItem._item_url +'&rID='+$rID;
		
		
		jQuery.ajax({
			'url':receiveItem._item_url,
			'data':$(this).serialize() + '&rID='+ $rID,
			'type':'post',
			'dataType':'json',
			'success':function(data)
			{
				//console.log('success');
				//console.log(receiveItem._sForm);
				if (receiveItem._sForm) //are we showing popup form?
				{
					if (data.status == 'failure')
					{
						$('#rcvItemlmDialog div.divForForm').html(data.div);
						$('#rcvItemlmDialog div.divForForm form').submit(receiveItem);
					}
					else
					{
						$('#rcvItemlmDialog div.divItem_').html(data.div);
						setTimeout(\"$('#rcvItemlmDialog').dialog('close') \",2000);
						receiveItem._sForm = false;
						$.lmNotify(data);
						if (data.status = 'success')
						{
							
							$.fn.yiiGridView.update('grid_received_item');
							$.fn.yiiGridView.update('grid_po_items');	
						}
						
					}
				} else
				{
					$.lmNotify(data);
					$.fn.yiiGridView.update('grid_received_item');
					$.fn.yiiGridView.update('grid_po_items');
				}
			} ,
			'cache':false});;
    return false;
		
	}");



	



?>



