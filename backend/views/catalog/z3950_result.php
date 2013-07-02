
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'z3950-result',
	   
	'dataProvider'=>$dataProvider,
	'type'=>'bordered condensed stripped',
	
	'columns'=>array(
		array('name'=>'isbn'),
		array('name'=>'title'),
		array(

    'header'=>'',
    'type'=>'raw',
    'value'=>'CHtml::Button(
        "Import",
        
        array(
            \'class\'=>\'btn btn primary btn-small\',
            \'onclick\'=>\'{
                importRecord._import_url="\'.
                    Yii::app()->createUrl(
                        "catalog/import",
                        array("id"=>$data["isbn"])
                    )
                .\'";
                importRecord();
                $("#itemDialog").dialog("open");}\'
            )
        );',
),
					array(

    'header'=>'',
    'type'=>'raw',
    'value'=>'CHtml::Button(
        "View",
        
        array(
            \'class\'=>\'btn btn primary btn-small\',
            \'onclick\'=>\'{
                updateItem._updateItem_url="\'.
                    Yii::app()->createUrl(
                        "acquisitionRequest/updateItem",
                        array("id"=>$data["isbn"])
                    )
                .\'";
                updateItem();
                $("#itemDialog").dialog("open");}\'
            )
        );',
),
							
							
							
		     

	),
)); ?>

<script type="text/javascript">
	function importRecord()
	{
		// public property
		var _import_url;
	 
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
						//$.fn.yiiGridView.update('grid_po_item');
					}
	 
			} ",
		))?>;
		return false;
	 
	}

</script>

