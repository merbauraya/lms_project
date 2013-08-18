
<?php
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="control-group">
        <label class="control-label" for="selfsuggest">Self Suggestion</label>
        <div class="controls">
            <?php echo CHtml::checkBox('selfsuggest', true,array('id'=>'selfsuggest')) ?>
        </div>
    </div>
    
	<?php 
		echo $form->select2row($model, 'suggested_by', array(
		'asDropDownList' => false,
		'attribute'=>'suggested_by',
		'options' => array(
			'delay'=>300,
			'minimumInputLength'=>3,
			'width' => '60%',
			'closeOnSelect' => false,
			'placeholder' => 'Select Patron',
			'allowClear' => false,
			'ajax' => array(
				'url' => CController::createUrl('patron/AjaxGetPatron'),
				'dataType' => 'json',
				'data' => 'js:function(term,page) 
							{ return {
								term: term, 
								page_limit: 10, 
								page: page,
                                type: "sel2",
                                match: "username",
								ret: "id",
								}; }',
				'results' => 'js:function(data,page) { return {results: data}; }',
			),
			'initSelection'=>'js:function(element,callback)
							  {var data={id:element.val(),text:element.val()};
							  callback(data);
							  }',
			
		),
		'events'=>array('change'=>'js:function(e)
			{
				var theID=e.val;
				console.log(e);
				
			}'				 
		)
		
	));
	
	
	?>
    

	
	
<?php echo $form->datepickerRow($model, 'suggest_date',
        		array('prepend'=>'<i class="icon-calendar"></i>',
				'options'=>array(
					'format'=>Yii::app()->params['dateFormat']),
					'autoclose'=>true)
				
				); 
		?>
	<?php //echo $form->textFieldRow($model,'description',array('class'=>'span6','maxlength'=>80)); ?>
	<?php //echo $form->dropDownListRow($model, 'department_id',
       //CHtml::listData(Department::model()->findAll('library_id = :library or library_id is null order by id',array(':library'=>LmUtil::UserLibraryId())), 'id', 'name')); 
?>	
	
<?php echo $form->dropDownListRow($model, 'budget_id',
      BudgetAccount::getDropDownList(!LmUtil::getSettingAcquisition('ENFORCE_BUDGET_SUGGESTION') == '1')); 
?>
	
	<?php //echo $form->textFieldRow($model,'staff_no',array('class'=>'span5','maxlength'=>50)); ?>

	
	<?php //echo $form->textFieldRow($model,'suggestor_hp',array('class'=>'span5','maxlength'=>12)); ?>
	
	<?php //echo $form->textFieldRow($model,'suggestor_office_no',array('class'=>'span5','maxlength'=>12)); ?>
	

<?php //echo $form->dropDownListRow($model, 'publication',AcquisitionRequest::model()->PublicationType);
       //CHtml::listData(Currency::model()->findAll(), 'id', 'name')); 
?>

	<?php //echo $form->textFieldRow($model,'suggestor_email',array('class'=>'span6','maxlength'=>70)); ?>

	<?php //echo $form->textFieldRow($model,'ebook_name',array('class'=>'span6','maxlength'=>70)); ?>



<?php // echo $form->dropDownListRow($model, 'library_id',
      // CHtml::listData(Library::model()->findAll(), 'id', 'name')); 
?>

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'user_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','User'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								'resizable'=>false,
								 
                                ),
                        ));

    $this->widget('bootstrap.widgets.TbExtendedGridView', array(
      'id'=>'account-grid',
	  'type'=>'striped bordered condensed',
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
		  	$(\"#vencode_plc_hldr\").val(\"$data->username\");
			
			$(\"#AcquisitionSuggestion_suggested_by\").val(\"$data->id\");
			$(\"#suggested_by\").val(\"$data->name\");
			$(\"#suggested_by\").trigger(\"change\");
			
			
                  "))',
          ),
        'username',
        'name',
		
       
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'vendor_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Vendor'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

    $this->widget('bootstrap.widgets.TbGridView', array(
      'id'=>'account-grid',
      'dataProvider'=>Vendor::model()->search(),
      'filter'=>Vendor::model(),
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "select_vendor",
          "id" => "select_vendor",
          "onClick" => "$(\"#vendor_dialog\").dialog(\"close\"); 
		  	$(\"#vencode_plc_hldr\").val(\"$data->code\");
			
			$(\"#AcquisitionSuggestion_suggested_by\").val(\"$data->id\");
			$(\"#venname_plc_hldr\").val(\"$data->name\");
			$(\"#vencode_plc_hldr\").trigger(\"change\");
			
			
			
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
