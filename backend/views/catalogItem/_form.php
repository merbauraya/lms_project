

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
    
        echo CHtml::activeHiddenField($model,'owner_library');
         echo $form->dropDownListRow($model, 'location_id',
            CHtml::listData(Location::model()->findAll('library_id=:lid',array(':lid'=>LmUtil::UserLibraryId())),'id','name'),
            array('class'=>'span5'));
  
	?>
	

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>25)); ?>

	<?php echo $form->dropDownListRow($model, 'smd_id',
        CHtml::listData(CatalogItemSmd::model()->findAll(),'id','name'),
		array('class'=>'span5'));
	?>
	<?php echo $form->dropDownListRow($model, 'category_id',
        CHtml::listData(CatalogItemCategory::model()->findAll(),'id','name')
		,array('class'=>'span5'));
	?>
	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->dropDownListRow($model, 'withdrawn_status',
		Lookup::getLookupOptions(Lookup::ITEM_WITHDRAWN_STATUS),array('class'=>'span5'));
	?>
	
	<?php echo $form->dropDownListRow($model, 'condition_id',
        CHtml::listData(CatalogItemCondition::model()->findAll(),'id','name'),
		array('class'=>'span5'));
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
