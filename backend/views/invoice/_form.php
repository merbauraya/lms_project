<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
	?>
	<div class="control-group">
		<label class="control-label required" for="Invoice_po_text_id">
			Purchase Order#
			<span class="required">*</span>
		</label>
		<div class="controls">
			<div class="input-append">
				<?php echo CHtml::activeTextField($model,'po_text_id',array('maxlength'=>20));   ?>
				<span class="add-on" onclick='$("#po_lookup").dialog("open"); return false;' style="cursor:pointer;">
				<i class="icon-search"></i>
				</span>
			</div>
			
			
		</div>	
	</div>
	
	<div class="control-group">
		<label class="control-label required" for="Invoice_vendor_id">
			Vendor
			<span class="required">*</span>
		</label>
		<div class="controls">
			
				<?php echo CHtml::activeTextField($model,'vendor_code',array('class'=>'span3 uneditable-input','maxlength'=>30));   ?>
				
			
			<?php echo CHtml::label('',false,array(
									'id'=>'vendor_name',
									'class'=>'label-inline'
			)); ?>
				
			
		</div>	
	</div>
	


	

	<?php echo $form->textFieldRow($model,'invoice_no',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->datepickerRow($model, 'invoice_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
		?>
		
	<?php echo $form->datepickerRow($model, 'due_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']))
				
				); 
		?>
	
	<?php echo $form->dropDownListRow($model, 'currency_id',
       CHtml::listData(Currency::model()->findAll(), 'id', 'name')); 
	?>
		
	<?php echo $form->textFieldRow($model,'invoice_amount',array('class'=>'span3','maxlength'=>13)); ?>
	
	<?php echo $form->textFieldRow($model,'local_amount',array('class'=>'span3','maxlength'=>13)); ?>
	

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); 
		?>
		&nbsp;
		<?php
		if (!$model->isNewRecord)
		{
			$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'secondary',
			'label'=>'Save as Draft',
			)); 
			
		}
		
		?>
	

	</div>

<?php $this->endWidget(); ?>
<?php  

/*
$this->widget('extcommon.LmWidget.LmVendorLookup', 
	array('options'=>array( 'id' =>'vendor_lookup',
	      'idfield'=>'Invoice_vendor_id', 
		  'codefield' => 'vendor_code',
		  'namefield' => 'caption'))); 
*/
?>

<?php
      /** provide vendor lookup 
	   * todo: move this as widget
	   **/
	  
	  $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'vendor_lookup',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Vendor'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

    $this->widget('bootstrap.widgets.TbExtendedGridView', array(
      'id'=>'vendor-grid',
	   'type'=>'striped bordered condensed',
      'dataProvider'=>$vendorDP,
      'filter'=>Vendor::model(),
      'template'=>'{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::link("+","#",
          array("name" => "select_vendor",
		        "class"=>"btn btn-mini",
          "id" => "select_vendor",
          "onClick" => "$(\"#vendor_lookup\").dialog(\"close\"); 
		  	$(\"#Invoice_vendor_code\").val(\"$data->code\");
			
			$(\"#Invoice_vendor_id\").val(\"$data->id\");
			$(\"#vendor_name\").html(\"$data->name\");
			$(\"#Invoice_vendor_id\").trigger(\"change\");
			
			
			
                  "))',
          ),
        'code',
        'name',
		
		'is_publisher'
        /*
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'recordstatus',
          'selectableRows'=>'0',
          'header'=>'Record Status',
          'checked'=>'$data->recordstatus'
        ),*/
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
      /** provide purhase order lookup 
	   * todo: move this as widget
	   **/
	  
	  $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'po_lookup',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchase Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

    $this->widget('bootstrap.widgets.TbExtendedGridView', array(
      'id'=>'po-grid',
	   'type'=>'striped bordered condensed',
      'dataProvider'=>$poDP,
      'filter'=>PurchaseOrder::model(),
      'template'=>'{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::link("+","#",
          array("name" => "select_vendor",
		        "class"=>"btn btn-mini",
          "id" => "select_vendor",
          "onClick" => "$(\"#po_lookup\").dialog(\"close\"); 
		  	$(\"#Invoice_po_text_id\").val(\"$data->text_id\");
			$(\"#Invoice_vendor_code\").val(\"$data->vendor_code\");
			$(\"#vendor_name\").html(\"$data->vendor_name\");
			
			
			
			
                  "))',
          ),
        'text_id',
		array('header'=>'Vendor','name'=>'vendor_code'),
		array('header'=>'Vendor Name','name'=>'vendor_name','value'=>'$data->vendor->name'),
		array('header'=>'PO Date','name'=>'po_date'),
		//array('header'=>'Vendor name','value'=>'$data->vendor->name'),
        /*
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'recordstatus',
          'selectableRows'=>'0',
          'header'=>'Record Status',
          'checked'=>'$data->recordstatus'
        ),*/
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
