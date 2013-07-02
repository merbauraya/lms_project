
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'circulation-rule-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

&nbsp;
<div id="checkin-msg" class="alert in alert-block fade alert-error invisible"></div>


	<?php //echo $form->errorSummary($model); ?>
	
	
	<?php echo CHtml::hiddenField('allow-checkout','0') ?>




	<?php echo $form->textFieldRow($model,'accession_number',array('class'=>'span3')) ?>


	
	
<div class="form-actions">
		<?php
			$this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Checkin',
			'type' => 'primary',
			'size' => 'medium',
			'htmlOptions' => array('id'=>'_btnCheckin',),
			));	 
		?>
		
		
	</div>
<?php $this->endWidget(); ?>

<?php
$_url = Yii::app()->createUrl('circulation/checkin');
Yii::app()->clientScript->registerScript('sc_checkin',"
$('body').on('click','#_btnCheckin',function(){

	var _url = '" . $_url ."' ;
	var _accession = $('#CirculationTrans_accession_number').val();

	//_url += _poId;
	jQuery.ajax({
		'id' : 'loadPoItem',
		'type' : 'POST',
		'dataType': 'json',
		'data': {accession: _accession},
		'url' : _url,
		'cache' : false,
		'success' : function(data)
			{
				
				$('#checkin-msg').html(data.message);
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
		
		return false;	
});

")


?>	
	
