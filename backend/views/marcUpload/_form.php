<?php
    $this->widget('extcommon.loading.LoadingWidget');

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Catalog By Template",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marc-upload-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
    
            <?php
            $this->widget( 'xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "/MarcUpload/HandleUpload"),
                //our XUploadForm
                'model' => $xupload,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'marc-upload-form'),
                'attribute' => 'file',
                'multiple' => false,
                //Note that we are using a custom view for our widget
                //Thats becase the default widget includes the 'form' 
                //which we don't want here
                'formView' => 'backend.views.MarcUpload._uploadform',
                )    
            );
            ?>
        </div>


	<?php echo $form->textFieldRow($model,'upload_type',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'action_if_matched',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'action_if_no_match',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'check_embedded_item'); ?>

	<?php echo $form->textFieldRow($model,'action_embedded_item',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'matching_rule',array('class'=>'span5')); ?>



	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php 
    $this->endWidget(); //form
    $this->endWidget(); //lmbox
?>
