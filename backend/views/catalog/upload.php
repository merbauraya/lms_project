<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Upload Marc",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create')),
								array('label'=>'Update','url'=>array('update','id'=>$model->id)),
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>



<div id="upload-task">

<?php
$this->widget('xupload.XUpload', array(
                    'url' => Yii::app()->createUrl("catalog/handleupload"),
                    'model' => $marc,
					'previewImages'=>false,
					'imageProcessing'=>false,
					'attribute' => 'file',
                    'multiple' => true,
					'options'=>array(
						'acceptFileTypes' => "js:/(\.|\/)(xml|mrc|marc|png)$/i",
					)
));
?>
</div>

<?php
 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'upload-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
)); 

?>

<?php echo CHtml::hiddenField('Catalog[id]',0);?>
<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Upload',
		)); ?>
	</div>

<?php $this->endWidget();
$this->endWidget();
?>