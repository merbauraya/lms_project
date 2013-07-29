<div class="grid-title"><h5>Purchase Order Ready for release</h5> </div>
<?php  

$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => null, 'flash' => '', 'caption' => '')); 

?>


<?php 
  $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_po',
	'selectableRows' => '2',
	'responsiveTable' => true,
	
	'dataProvider'=>$dataProvider,
	'template'=> '{items}',
	'bulkActions' => array(
	'actionButtons' => array(
		array(
			'buttonType' => 'button',
			'type' => 'primary',
			'size' => 'small',
			'label' => 'Release ',
			'click' => 'js:function(values){releasePO(values);}'
			)
		),
		// if grid doesn't have a checkbox column type, it will attach
		// one and this configuration will be part of it
		'checkBoxColumnConfig' => array(
		    'name' => 'id'
		),
	),
	'columns'=>array(
	    
		array('name'=>'id',
                    'class'=>'CCheckBoxColumn',),
		array('name'=>'text_id'),
        array('name'=>'budget_id','header'=>'Budget','value'=>'$data->budget->name'),
		array('name'=>'vendor_id','header'=>'Vendor','value'=>'$data->vendor->name'),
		array('name'=>'po_date','header'=>'PO Date'),
		array('name'=>'po_amount','header'=>'PO Amount'),
		
		
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
                $("#itemDialog").dialog("open");}\'
            )
        );',
),
	),
));

?>
<?php
$_url = Yii::app()->controller->createUrl('purchaseorder/release');
Yii::app()->clientScript->registerScript('releasePO', "
    function releasePO(values) 
	{
        var _url = '" . $_url ."' ;
		for (var i = 0; i < values.length; i++) 
		{
			console.log(values[i].value);
			//alert(myStringArray[i]);
			//Do something
		}
		var selectionIds = $.fn.yiiGridView.getSelection(\"grid_po\");
		console.log(selectionIds);
		
		jQuery.ajax({
			url : _url,
			data : {ids: selectionIds} ,
			dataType : 'json',
			type : 'post',
			success : function(data)
						{
							$.lmNotify(data);
							$.fn.yiiGridView.update(\"grid_po\");
													
							//afterDelete(th,true,data);
                        },
		
		
			error   : function(data)
						{
							$.lmNotify(data);
						}
		 });				
		
		
		
    }
", CClientScript::POS_END);


?>
