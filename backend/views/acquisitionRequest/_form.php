<?php
	/***
	*  This the main form for creating suggestion
	*
	*
	*/


?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-request-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<label class="control-label" for="AcquisitionRequest_requested_by">Requested By</label>
		<div class="controls">
			<input type="hidden" id="__user_id">
			<input type="hidden" id="__fullname">
			<input type="hidden" name="AcquisitionRequest[requested_by]" id="AcquisitionRequest_requested_by" value="<?php echo $model->requested_by ?>">
			<input type="hidden" name="AcquisitionRequest[id]" id="AcquisitionRequest_id" value="<?php echo $model->id ?>">
			<input class="span5" name="requested_by" id="__user_fullname" type="text" value="<?php echo isset($model->patron->name)? $model->patron->name : '';  
			
			?>">
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'icon'=>'icon-search',
			'type'=>'',
			'label'=>'...',
		'htmlOptions'=>array('onclick'=>'$("#user_dialog").dialog("open"); return false;'))); ?>
		</div>
	</div>

	<?php echo $form->datepickerRow($model, 'request_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']),
					
					)
				
				); 
		?>
<?php echo $form->dropDownListRow($model, 'department_id',
       CHtml::listData(Department::model()->findAll(), 'id', 'name')); 
?>	
	
<?php echo $form->dropDownListRow($model, 'budget_id',
       CHtml::listData(BudgetAccount::model()->findAll(), 'id', 'name')); 
?>

<?php echo $form->dropDownListRow($model, 'library_id',
       CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
?>

	
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<!--todo move this as widget -->
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'user_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','User'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

    $this->widget('bootstrap.widgets.TbGridView', array(
      'id'=>'grid_patron',
      'dataProvider'=>Patron::model()->search(),
      'filter'=>Patron::model(),
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "select_user",
          "id" => "select_user",
          "onClick" => "$(\"#user_dialog\").dialog(\"close\"); 
		  	$(\"#__username\").val(\"$data->username\");
			
			$(\"#__user_id\").val(\"$data->id\");
			$(\"#__user_fullname\").val(\"$data->name\");
			$(\"#__user_fullname\").trigger(\"change\");
			
			
                  "))',
          ),
        'username',
        'name',
		
       
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<?php
Yii::app()->clientScript->registerScript('__request_create', "
$('#__user_fullname').change(function(){
		
		var venid = $('#vencode_plc_hldr').val();
		var rkey = $('#row_id').val();
		var uid = $('#__user_id').val();
		var uname = $('#__fullname').val();
		$('#AcquisitionRequest_requested_by').val(uid);
		$('#requested_by').val(uname);
		//rkey = rkey.replace('[','\\\\[');
		//rkey = rkey.replace(']','\\\\]');
		//alert (rkey);
		//$('#'+ jqSelector(rkey)).val(venid);
			
	});
");

?>

