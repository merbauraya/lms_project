<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<div id="bk_cover" class="dialog-bk-cover" style="width:61;height:81;">
	<img id="img_cover">

</div>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php
    echo $form->textFieldRow($model,'issn');
?>
<div class="control-group">
	<label class="control-label" for="AcquisitionSuggestionItem_isbn10">ISBN10</label>
	<div class="controls">
	     <?php echo $form->textField($model,'isbn',array('class'=>'span2','maxlength'=>15)); ?>
	 </div>
</div>
<div class="control-group">
	<label class="control-label" for="AcquisitionSuggestionItem_isbn_13">ISBN13</label>
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
        <?php echo CHtml::activeHiddenField($model,'acq_suggestion_id');  ?>

	<?php echo $form->textFieldRow($model,'author',array('class'=>'span4','maxlength'=>40)); ?>
        	<?php echo $form->textFieldRow($model,'publisher',array('class'=>'span4','maxlength'=>40,'title'=>'Publisher')); ?>
        	<?php echo $form->textFieldRow($model,'year',array('class'=>'span4','maxlength'=>40)); ?>
        	<?php echo $form->textFieldRow($model,'edition',array('class'=>'span4','maxlength'=>40)); ?>   
        	<?php echo $form->textFieldRow($model,'price',array('class'=>'span2','maxlength'=>40)); ?> 
            <?php echo $form->dropDownListRow($model,'currency',Currency::getDropDownList()) ?>    
            <?php echo $form->textFieldRow($model,'local_price',array('class'=>'span2','maxlength'=>40)); ?> 
        	<?php echo $form->textFieldRow($model,'number_of_copy',array('class'=>'span4','maxlength'=>40)); ?>
            <?php echo $form->textFieldRow($model,'note',array('class'=>'span4','maxlength'=>40)); ?>
                  	 <div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Cancel','htmlOptions'=>array('onclick'=>'{$("#item-lmDialog").dialog("close");return false;}')

)); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    
    // This function is called by the "ISBN check" button above
    function isbnCheck()
    {
        
		$('#bk_cover').addClass('ajax_loading_round');
		<?php echo CHtml::ajax(array(
                // the controller/function to call
                'url'=>CController::createUrl('acquisitionSuggestion/isbnCheck'), 
 
                // Data to be passed to the ajax function
                // Note that the ' should be escaped with \
                // The field id should be prefixed with the model name eg Vehicle_field_name
				
                'data'=>array('isbn'=>'js:$(\'#AcquisitionSuggestionItem_isbn\').val()','isbn13'=>'js:$(\'#AcquisitionSuggestionItem_isbn_13\').val()', 

                       ),
                'type'=>'post',
                'dataType'=>'json',
                'success'=>"function(data)
                {
                    // data will contain the json data passed by the isbncheck action in the controller
                    // Update the status
                    //$('#isbnstatus').html(data.status);
                    if (data.status!='error')
                    {
                        // If there are no errors then update the fields


                        $('#AcquisitionSuggestionItem_title').val(data.title);
                        $('#AcquisitionSuggestionItem_publisher').val(data.publisher);
                        $('#AcquisitionSuggestionItem_isbn_13').val(data.isbn13);
                        $('#AcquisitionSuggestionItem_isbn').val(data.isbn10);
                        $('#AcquisitionSuggestionItem_year').val(data.publisheddate);
                          //special case for author  , it returned as array
                        var author='';
                        for (var i=0,len = data.author.length; i < len; i++)
                        {
                           author += data.author[i];
                           if (i < (len-1))
                              author +=',';
                        }
                         $('#AcquisitionSuggestionItem_author').val(author);


                    }
 
                } ",
                ))?>;
        return false;  
    }
    </script>
