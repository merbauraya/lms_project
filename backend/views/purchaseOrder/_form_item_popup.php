
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'purchaseorder-item-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<div id="bk_thumbnail">
     <img id="img_thumbnail" src="">
</div>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="control-group">
	<label class="control-label" for="PurchaseOrderItem_isbn10">ISBN10</label>
	<div class="controls">
	     <?php echo $form->textField($model,'isbn',array('class'=>'span2','maxlength'=>15)); ?>
	 </div>
</div>
<div class="control-group">
	<label class="control-label" for="PurchaseOrderItem_isbn_13">ISBN13</label>
	<div class="controls">
	     <?php echo $form->textField($model,'isbn_13',array('class'=>'span2','maxlength'=>15)); ?>
	     <?php //echo CHtml::button('ISBN Check', array( 'onclick'=>"{isbnCheck();}" ) ); ?>
	     <?php $this->widget('bootstrap.widgets.TbButton',array(
'label' => ' ',
'size' => 'small',
'icon' => 'icon-search',
'htmlOptions' => array('title'=>'Click to query ISBN',
					  'onclick'=>'isbnCheck();',
					  'rel'=>'tooltip',),
));                ?>

        </div>
        	<div id='isbnstatus'></div>
</div>


	<?php echo $form->textFieldRow($model,'title',array('class'=>'span4','maxlength'=>40)); ?>
        <?php echo CHtml::activeHiddenField($model,'id');  ?>
        <?php echo CHtml::activeHiddenField($model,'purchase_order_id');  ?>
		
	<?php echo $form->textFieldRow($model,'author',array('class'=>'span4','maxlength'=>40)); ?>
        	<?php echo $form->textFieldRow($model,'publisher',array('class'=>'span4','maxlength'=>40,'title'=>'Publisher')); ?>
        	<?php echo $form->textFieldRow($model,'publication_date',array('class'=>'span4','maxlength'=>40)); ?>
        	<?php //echo $form->textFieldRow($model,'edition',array('class'=>'span4','maxlength'=>40)); ?>   
        	<?php echo $form->textFieldRow($model,'local_price',array('class'=>'span4','maxlength'=>40)); ?>     
        	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span4','maxlength'=>40)); ?>
			<?php echo $form->dropDownListRow($model, 'department_id',
       CHtml::listData(Department::model()->findAll(), 'id', 'name')); 
?>	
	
<?php echo $form->dropDownListRow($model, 'budget_id',
       CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name')); 
?>
<?php echo $form->textFieldRow($model,'note',array('class'=>'span4','maxlength'=>50)); ?>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); 
	?>
	&nbsp;
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Cancel','htmlOptions'=>array('onclick'=>'{$("#item-lmDialog").dialog("close");return false;}')

)); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    
    // This function is called by the "ISBN check" button above
    function isbnCheck()
    {
        <?php echo CHtml::ajax(array(
                // the controller/function to call
                'url'=>CController::createUrl('AcquisitionSuggestion/isbnCheck'), 
 
                // Data to be passed to the ajax function
                // Note that the ' should be escaped with \
                // The field id should be prefixed with the model name eg Vehicle_field_name
                'data'=>array('isbn'=>'js:$(\'#PurchaseOrderItem_isbn\').val()','isbn13'=>'js:$(\'#PurchaseOrderItem_isbn_13\').val()', 
 //"js:$('#".CHtml::activeId($model,'postcode')."').val()", 
                // To pass multiple fields, just repeat eg:
                //              'other_data'=>'js:$(\'#field_id\').val()',
                                ),
                'type'=>'post',
                'dataType'=>'json',
                'success'=>"function(data)
                {
                    // data will contain the json data passed by the isbncheck action in the controller
                    // Update the status
                    //$('#isbnstatus').html(data.status);
                    if (data.error=='false')
                    {
                        // If there are no errors then update the fields


                        $('#PurchaseOrderItem_title').val(data.title);
                        $('#PurchaseOrderItem_publisher').val(data.publisher);
                        $('#PurchaseOrderItem_isbn_13').val(data.isbn13);
                        $('#PurchaseOrderItem_isbn').val(data.isbn10);
                        $('#PurchaseOrderItem_publication_date').val(data.publisheddate);
                          //special case for author  , it returned as array
                        var author='';
                        for (var i=0,len = data.author.length; i < len; i++)
                        {
                           author += data.author[i];
                           if (i < (len-1))
                              author +=',';
                        }
                         $('#PurchaseOrderItem_author').val(author);


                    }
 
                } ",
                ))?>;
        return false;  
    }
    </script>