<?php
	/*
	$this->widget('bootstrap.widgets.TbButton',array(
		'label' => 'Load Purchase Order Item',
		'type' => 'primary',
		'size' => 'medium',
		'htmlOptions' => array('id'=>'btn_load_po_items',),
	));

*/
?>
<div id="div_po_items">
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
		'dataProvider'=>$poItemDP,
		'extendedSummary' => array(
			'columns' => array(
				'local_price' => array('label'=>'Total Amount', 'class'=>'TbSumOperation')
			)
		),
		'extendedSummaryOptions' => array(
			'class' => 'well pull-right',
			'style' => 'width:150px;height:10px;'
		),
		'template'=> '{items}{extendedSummary}',
		'bulkActions' => array(
			'actionButtons' => array(
				array(
					'buttonType' => 'button',
					'type' => 'primary',
					'size' => 'small',
					'label' => 'Add Item',
					'click' => 'js:batchApprove',
					'htmlOptions'=>array('class'=>'bulk-action'),
				),
			
			),
	
			'checkBoxColumnConfig' => array(
				'name' => 'id'
			),
		),
		'columns'=>array(
			array('name'=>'item_no','header'=>'#'),
			array('name'=>'id',
				'class'=>'CCheckBoxColumn',),
			array('name'=>'isbn','header'=>'ISBN','value'=>'$data->isbn'),
			array('name'=>'title','header'=>'Title'),
			
			array('name'=>'publisher','header'=>'Publisher'),
			array('name'=>'local_price','header'=>'Price'),
			array('name'=>'quantity','header'=>'Quantity'),
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
		\'onclick\'=>\'{
		updateItem._updateItem_url="\'.
		Yii::app()->createUrl(
		"purchaseOrder/updateItem",
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
$_url = Yii::app()->createUrl('invoice/loadPoItem');
Yii::app()->clientScript->registerScript('sc_load_po_item',"
$('body').on('click','#btn_load_po_items',function(){

var _url = '" . $_url ."' ;
var _poID = $('#Invoice_po_text_id').val();
console.log (_suggId);
_url += _poID;
jQuery.ajax({
	'id' : 'loadSuggItem',
	'url' : _url,
	'cache' : false,
	'success' : function(html)
		{jQuery('#div_po_items').html(html)}});
	
	return false;	
});

")


?>