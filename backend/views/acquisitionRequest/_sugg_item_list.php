<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'type'=>'striped bordered condensed',
	'id'=>'grid_sugg_items',
	'selectableRows' => '2',
	'dataProvider'=>$itemsDP,
	'template'=>"{items}\n{pager}",
    'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'type' => 'primary',
				'size' => 'small',
				'label' => 'Promote Suggestion',
				'click' => 'js:batchSuggApprove',
                
				'htmlOptions'=>array('class'=>'bulk-action'),
				),
			array(
				'buttonType' => 'link',
				'type' => 'warning',
				'size' => 'small',
				'label' => 'Reject Item',
				'click' => 'js:batchSuggReject',
				'htmlOptions'=>array('class'=>'bulk-action'),
                ),	
			array(
				'buttonType' => 'link',
				'type' => 'danger',
				'size' => 'small',
				'label' => 'Delete Item',
				'icon'=> 'icon-trash',
				'click' => 'js:batchSuggDelete',
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
        array('name'=>'author'),
		
		array('name'=>'publisher','header'=>'Publisher'),
        array('name'=>'date_created','header'=>'Created'),
        array('name'=>'local_price','header'=>'Local Price'),
        
    
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
                        "acquisitionSuggestion/updateItem",
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


<?php $this->endWidget(); ?>



