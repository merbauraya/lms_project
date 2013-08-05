<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'circulation-rule-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
    <?php
        $this->beginWidget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>array(
                    array('id'=>'tabCategory','label'=>'Category', 'content'=>$this->renderPartial('_formcategory',array('model'=>$model,'form'=>$form),true), 'active'=>true),
                    array('id'=>'tabRule','label'=>'Rule', 'content'=>$this->renderPartial('_formrule',array('model'=>$model,'form'=>$form),true)),
                    array('id'=>'tabDefault','label'=>'Default Rule', 'content'=>$this->renderPartial('_formdefault',array('model'=>$model,'form'=>$form),true)),
		
                ),
                'events'=>array('shown'=>'js:loadDefaultRule'),
));
    
    
    $this->endWidget('bootstrap.widgets.TbTabs');

    echo $form->errorSummary($model); 
    echo CHtml::activeHiddenField($model,'library_id');
 
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
Yii::app()->clientScript->registerScript('_cirrule', "
   
    function loadDefaultRule(e)
    {
        if (e.target.getAttribute('href') != '#tabDefault')
            return;
        
        jQuery.ajax({
        'id' : 'loadPoItem',
        'type' : 'GET',
        'dataType': 'json',
        'data': {ret: 'json'},
        'url' : '/circulationRule/getDefault/',
        'cache' : false,
        'success' : function(data)
          {
            console.log(data);
            if (data.exist == false)
                return;
            for (var key in data.default)
            {
                jQuery.each(data.default[key], function(id, value) {
                    $('#Default_'+ id).val(value);
                    console.log (id +'-' + value);
                });
            }
           
         
          }
        });
    } 
    
");
 
?>
