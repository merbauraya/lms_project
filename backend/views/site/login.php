<div style="text-align: center;margin-bottom: 1px">
	<?php //echo CHtml::image(Yii::app()->baseUrl."/images/hzlogo_small.jpg",'Logo');?>


<h5 class="form-title">Login to Merbau LMS Admin</h6>
</div>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'login-form',
	'type'=>'horizontal',
	'enableClientValidation'=>true,
	'htmlOptions'=>array('class'=>'well'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	
	
	<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
	 <?php echo $form->toggleButtonRow($model, 'rememberMe'); ?>
	
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
</div>
	

<?php $this->endWidget(); ?>
</div><!-- form -->
