<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'catalog-document-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php /*echo $form->textFieldRow($model,'catalog_id',array('class'=>'span5',
	'onclick'=>new CJavaScriptExpression('function(){alert("Yes");}'))); */?>
	<div class="control-group ">
		<label class="control-label required" for="CatalogDocument_catalog_id">
		Catalog
			<span class="required">*</span>
		</label>
		<div class="controls">
		<input id="CatalogDocument_catalog_id" class="span5" type="text" name="CatalogDocument[catalog_id]" onclick="function(){alert("Yes");}">
	<input type="button" class="btn btn-primary" value="Lookup" name="get_catalog_btn" onclick="$('#catalogdialog').dialog('open'); return false;" > 
		</div>
		
		
		
</div>
	
<?php
$this->widget('bootstrap.widgets.TbToggleButton', array(
'onChange' => 'js:function($el, status, e)
			 { if (status) {
			 	 $("div#singleAcc").show();
				 $("div#multiAcc").hide();	
			 	}else
				{
					$("div#singleAcc").hide();
				 	$("div#multiAcc").show();
				} 
			 
			 	
			 }',
'name'=>'tglAccession',
'enabledLabel' => 'Create Single Accession',
'disabledLabel' => 'Create Multiple Accession',
'value'=>true,
'width'=>500,
'enabledStyle'=>null,
'customEnabledStyle'=>array(
'background'=>'#FF00FF',
'gradient'=>'#D300D3',
'color'=>'#FFFFFF'
),
'customDisabledStyle'=>array(
'background'=> "#FFAA00",
'gradient'=> "#DD9900",
'color'=> "#333333"
)
)); ?>


<div id="singleAcc">


	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span5','maxlength'=>20)); ?>

</div>

<div id="multiAcc" style="display: none">
	 <?php echo $form->dropDownListRow($model, 'acc_series',
array('Something ...', '1', '2', '3', '4', '5')); ?>
	
	
</div>

	<?php echo $form->textFieldRow($model,'library_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'location_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'barcode',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'book_number',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'classification_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'call_number',array('class'=>'span5','maxlength'=>40)); ?>

	<?php echo $form->textFieldRow($model,'document_status_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'category_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'control_number',array('class'=>'span5','maxlength'=>50)); ?>
<div class="controls">
<?php
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	//'placement'=>'left',
	'tabs'=>array(
		array('label'=>'Acquisition Info', 'content'=>'Home Content', 'active'=>true),
		array('label'=>'Approval Info', 'content'=>'Profile Content'),
		array('label'=>'Messages', 'content'=>'Messages Content'),
	),
));

?>
</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'catalogdialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'List User',
        'autoOpen'=>false,
    ),
));

$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$modelCatalog->search(),
	'template'=>"{items}",
	'filter'=>Catalog::model(),
	'columns'=>array(
        'id',
        'title_245a',
    // and dont forget to clear these function 
        // array(
            // 'class'=>'CButtonColumn',
        // ),
        array(
                                'header'=>'',
                                'type'=>'raw',
                                'value'=>'CHtml::Button(
                                        "+"
                                        , array(
                                            "name" => "get_link"
                                            , "id" => "get_link"
                                            , "onClick" => "$(\"#catalogdialog\").dialog(\"close\");$(\"#CatalogDocument_catalog_id \").val(\"". $data->id."\");"))',
                            ),
    ),


    //echo 'CGRIDVIEW here';
    // these area will be filled with CGridView
));


$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
