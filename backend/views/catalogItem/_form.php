

<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-item-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); */?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <label class="control-label">Control Number</label>
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model,'control_number',array('append'=>'<i class="icon-search"></i>')) ;
                echo '&nbsp;';
                $this->widget('bootstrap.widgets.TbButton',array(
                    'label' => 'Secondary',
                    'size' => 'small',
                    'id'=>'ctl_lookup',
                    'htmlOptions'=>array('onClick' =>'controlLookup()'),
                ));
            
            ?>
        </div>
    
    </div>
	
	<?php 
    
        
            echo $form->dropDownListRow($model, 'owner_library',
                CHtml::listData(Library::model()->findAll(), 'id', 'name'),
                
                array('empty'=>'Select Library',
                'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('lookup/GetLocationByLibrary'), //url to call.
                    'data'=>array('library'=>'js:this.value'),
                    'update'=>'#CatalogItem_location_id',
                ),
                'class'=>'span5',
            )); 
    if ($model->isNewRecord){    
            echo $form->dropDownListRow($model, 'location_id',array('Select Location'),array('class'=>'span5'));
    }else
    {
        //echo $form->dropDownListRow($model, 'owner_library',CHtml::listData(Library::model()->findAll(), 'id', 'name'),array('class'=>'span5'));
        echo $form->dropDownListRow($model, 'location_id',CHtml::listData(Location::model()->findAll('library_id=:lid',array(':lid'=>$model->owner_library)),'id','name'),array('class'=>'span5'));
    }
	?>
	

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>25)); ?>

	<?php echo $form->dropDownListRow($model, 'smd_id',
		Lookup::getLookupOptions(Lookup::ITEM_SMD),array('class'=>'span5'));
	?>
	<?php echo $form->dropDownListRow($model, 'category_id',
		Lookup::getLookupOptions(Lookup::ITEM_CATEGORY),array('class'=>'span5'));
	?>
	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->dropDownListRow($model, 'withdrawn_status',
		Lookup::getLookupOptions(Lookup::ITEM_WITHDRAWN_STATUS),array('class'=>'span5'));
	?>
	
	<?php echo $form->dropDownListRow($model, 'condition_id',
		Lookup::getLookupOptions(Lookup::ITEM_CONDITION_STATUS),array('class'=>'span5'));
	?>
	
	
	<?php echo $form->dropDownListRow($model, 'lost_status',
		Lookup::getLookupOptions(Lookup::ITEM_LOST_STATUS),array('class'=>'span5'));
	?>
	<?php echo $form->dropDownListRow($model, 'not_for_loan_status',
		Lookup::getLookupOptions(Lookup::ITEM_NOTFORLOAN),array('class'=>'span5'));
	?>

<script type="text/javascript">
function controlLookup()
{
 
    $("#ctlLookupDialog").dialog("open");
    $(".ui-dialog-titlebar").hide();
}

</script>
