
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'checkout-form',
	'enableAjaxValidation'=>true,
	'type'=>'horizontal',
    	'clientOptions'=>array(
		'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        
	),
)); ?>

   
    <div id="checkout-msg" class="alert in alert-block fade alert-error invisible">
  
</div>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo CHtml::hiddenField('patron_name') ?>

<?php 
    echo $form->dropDownListRow($model, 'library_id',
        CHtml::listData(Library::model()->findAll(), 'id', 'name'),array('class'=>'span7')); 
    //echo CHtml::activeHiddenField($model,'patron_username');
    //echo $form->textFieldRow($model,'patron_username');
	 echo $form->textFieldRow($model,'member_card_number',array('class'=>'span3'));
/*    
    echo $form->autocompleteRow($model,'patron_username',array(
            
            'source'=>$this->createUrl('patron/AjaxGetPatron',array('ret'=>'uname','page_limit'=>10)),
            'options'=>array(
                'minLength'=>'4',
                'delay'=>300,
                'showAnim'=>'fold',
                'select'=>"js:function(event,ui)
                    {
                        $('#username').html(ui.item.name);
                        $('#CirculationTrans_patron_username').val(ui.item.id);
                        
                        $('#CirculationTrans_patron_username_em_').html(ui.item.name);
                        $('#CirculationTrans_patron_username_em_').toggle();
                      
                    }"
            ),
            //'htmlOptions'=>array(
            //    'class'=>'span2',
            //),
    )); */
     echo $form->autocompleteRow($model,'accession_number',array(
            
            'source'=>$this->createUrl('CatalogItem/AjaxGetAvailableItem',array('ret'=>'accession','page_limit'=>10)),
            'options'=>array(
                'minLength'=>'4',
                'delay'=>300,
                'showAnim'=>'fold',
                'select'=>"js:function(event,ui)
                    {
                      $('#CirculationTrans_accession_number').val(ui.item.id);
                      //  $('#CirculationTrans_patron_username_em_').html(ui.item.name);
                      //  $('#CirculationTrans_patron_username_em_').toggle();
                      
                    }"
            ),
          
    ));
    
 

	
	?>
<div class="form-actions noColorNoBorder">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Checkout',
            'id'=>'btnCheckout'
		)); ?>
	</div>
<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScript('lookup', "
    $('#CirculationTrans_patron_username').focusin(function(){
        console.log('int');
    
    
    });
       $('#CirculationTrans_member_card_number').blur(function(){
            jQuery.ajax({
                'id' : 'loadPatron',
                'type' : 'POST',
                'dataType': 'json',
                'data': {cardnumber: $('#CirculationTrans_member_card_number').val(),
                        library:$('#CirculationTrans_library_id').val(),
                        ret:'json'
                        },
                'url' : '/circulation/getStatusAndHolding',
                'cache' : false,
                'success' : function(data)
                  {
                    console.log(data.user.allowcheckout);
                  
                    if (!data.user.allowcheckout)
                    {
                        
                         
                         $('#checkout-msg').html(data.user.msg);
                         $('#checkout-msg').removeClass('invisible alert-info');
                         $('#checkout-msg').addClass('alert-error');
                    
                    }else
                    {
                        $('#checkout-msg').removeClass('invisible alert-error');
                        $('#checkout-msg').addClass('alert-info');
                        $('#checkout-msg').html(data.user.name)
                    
                    }
                    $('#checkout-msg').html(data.message);
                    if (data.status == 'fail')
                    {
                      $('#checkin-msg').removeClass('alert-success alert-error invisible');
                      $('#checkin-msg').addClass('alert-error');
                    } else
                    {
                      $('#checkin-msg').removeClass('alert-success alert-error invisible');
                      $('#checkin-msg').addClass('alert-success'); 
                   
                    }
                   
                 
                  }
                });
        
    
    });
    
    $( '#btnCheckout').click(function() 
    {
        
        $('#checkout-msg').addClass('invisible');
        return true;
    })
    


");
 
?>
