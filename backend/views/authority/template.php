<?php
$this->widget('extcommon.loading.LoadingWidget');

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
    'htmlOptions'=>array('class'=>'btn-secondary','name'=>'btnpromotell',
		'id'=>'btn_show_tag',
        'rel'=>'tooltip',
        )
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
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'addTagDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Add Tag',
        'autoOpen'=>false,
        'width'=>'600',
		'height'=>'520',
        'modal'=>true,
    ),
));
	
?>
<div class="divForForm"></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
Yii::app()->clientScript->registerScript('show_tag',"
$('#btn_show_tag').live('click',function()
    {
        Loading.show();
        var templateID = $('#authorityTemplate').val();
        $('#ajax-status').addClass('ajax_loading');
        {jQuery.ajax(
            {'id':'sent',
            type:'POST',
            data: {authType: templateID},
            url:'/authority/rendertemplatetag/',
            cache:false,
            success:function(html)
                {
                    $('#ajax-status').removeClass('ajax_loading');
                    $('#templateDiv div.templateContent').html(html);
                    Loading.hide();                                    
                }
            });return false;
            }
        
         
         
        
    });
    $('.ck-sf').live('change',function()
    {
        
        var parentID = $(this).parent().closest('div[id]').attr('id');
        //find tag checkbox
        var tagCK = $(parentID).find('input:checkbox:first');
        tagCK.prop('checked',true);
        console.log(tagCK);
        
         
         
        
    });

    
  

");


?>

<?php
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 
?>
