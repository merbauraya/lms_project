<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'action'=>array('acquisitionsuggestion/uploadmarc'),
	'htmlOptions'=>array(
	'enctype'=>'multipart/form-data'/*,'target'=>'upload_target'*/),
)); ?>

<?php
$this->widget('CMultiFileUpload', array(
       'model'=>$model,
       //'attribute'=>'files',
	   'name'=>'marc',
	   'max'=>-1,
       'accept'=>'mrc|marc',
       'options'=>array(
          'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
          'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
          'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
          'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
          'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
          'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
       ),
    ));
	
	echo CHtml::ajaxSubmitButton('Submit',array('acquisitionsuggestion/uploadmarc'));
	
?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>	
<iframe id="upload_target" name="upload_target" style="width:10px; height:10px; display:none"></iframe>