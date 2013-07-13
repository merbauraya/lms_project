
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Authorities Template",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>
<?php

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'catalog-list',
		'type'=>'horizontal',
		'action'=>array('authority/rendertemplate'),
		
	)); 
	
?>
		<p class="help-block">&nbsp</p>
		<div class="control-group">
			<label class="control-label">Select Template</label>
			<div class="controls">
<?php
			
    echo CHtml::DropDownList('authorityTemplate', 'Select Template', CHtml::listData($model, 'id', 'name'),array('class'=>'span4')); 
	echo '&nbsp';
	
     $this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Show Tag',
	'size' => 'medium',
	'icon' =>'icon-th-list',
	'htmlOptions'=>array('class'=>'btn-primary','name'=>'btnpromotell',
		'id'=>'btn_show_tag',
        )
)); 
   echo '&nbsp';
    
    
    $this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Add Authority Type',
	'size' => 'medium',
	'icon' =>'icon-plus',
	'htmlOptions'=>array('class'=>'btn-primary','name'=>'btnpromotell',
		'id'=>'btn_promote_sugg',
        'onClick'=>'newAuthorityType();')
)); 
    $this->endWidget(); 

		?>
			</div>
		</div>
		<div id='templateDiv' class="marc-input">
             <p id="ajax-status"></p>
            <div class='templateContent'></div>
        
        </div>
	
	
	

<?php
    $this->endWidget(); 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'newAuthorityTypeDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Receive Item',
        'autoOpen'=>false,
        'width'=>'600',
		'height'=>'520',
        'modal'=>true,
    ),
));
$this->endWidget(); 
?>    


<?php
Yii::app()->clientScript->registerScript('show_tag',"
$('#btn_show_tag').live('click',function()
    {
        var templateID = $('#authorityTemplate').val();
        $('#ajax-status').addClass('ajax_loading');
        {jQuery.ajax(
            {'id':'sent',
            type:'POST',
            data: {authType: templateID},
            url:'/authority/rendertemplate/',
            cache:false,
            success:function(html)
                {
                    $('#ajax-status').removeClass('ajax_loading');
                    $('#templateDiv div.templateContent').html(html);
                                    
                }
            });return false;
            }
        
         
         
        
    });

");


?>

<?php
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 
?>
