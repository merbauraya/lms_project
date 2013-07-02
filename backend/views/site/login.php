<div style="text-align: center;margin-bottom: 1px">
	<?php echo CHtml::image(Yii::app()->baseUrl."/images/hzlogo_small.jpg",'Logo');?>
</div>

<h6 class="form-title">Login</h1>

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


<?php  /* $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 
*/
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
	 <?php echo $form->toggleButtonRow($model, 'rememberMe'); ?>
	<?php //echo $form->checkboxRow($model, 'rememberMe'); ?>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
</div>
	

<?php $this->endWidget(); ?>
</div><!-- form -->
