<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create New Authorities",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>

<?php
//the javascript that doing the jobs
 $script = "function showItemValue(){
              document.getElementById('templateDiv').innerHTML = document.getElementById('catalog').value;
}";

Yii::app()->clientScript->registerScript('js1', $script, CClientScript::POS_END);
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
			
			echo CHtml::DropDownList('authorityTemplate', 'Select Template', CHtml::listData(AuthorityType::model()->findAll(), 'id', 'name'),array('class'=>'span4')); 
			echo '&nbsp';
            $this->widget('bootstrap.widgets.TbButton',array(
                'label' => 'Load Template',
                'size' => 'medium',
                'icon' =>'icon-th-list',
                'htmlOptions'=>array('class'=>'btn-primary','name'=>'btnpromotell',
                    'id'=>'btn_show_form',
                    'rel'=>'tooltip',
                    )
            )); 
            
		
		

		?>
			</div>
		</div>
		<div id='templateDiv' class="marc-input">
            <p id="ajax-status"></p>
            <div class="templateContent"></div>
        </div>
	
	
	
<?php $this->endWidget(); //form
$this->endWidget();  //lmbox
?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'marc-leader-dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Marc Leader'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
								 
                                ),
                        ));

						
	//echo $this->renderPartial('_leader', array());   	
		
?>
	<div class="divForForm">
    </div>
<?php					
	$this->endWidget();						
?>						

<?php
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 
?>
<?php
Yii::app()->clientScript->registerScript('show_form',"
$('#btn_show_form').live('click',function()
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
 
