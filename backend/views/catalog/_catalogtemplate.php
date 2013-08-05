<?php
    $this->widget('extcommon.loading.LoadingWidget');

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Catalog By Template",
		//'headerIcon' => 'icon-user',
		'content' => '',
	));
	
?>

<?php
//the javascript that doing the jobs
 $script = "function showItemValue(){
              document.getElementById('templateDiv').innerHTML = document.getElementById('catalog').value;
}";

//Yii::app()->clientScript->registerScript('js1', $script, CClientScript::POS_END);
?>
<?php

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form-marc-record',
		'type'=>'horizontal',
		
		
	)); 
	
?>
		<p class="help-block">&nbsp</p>
		<div class="control-group">
        <label class="control-label">Select Template</label>
		<div class="controls">
		<?php
			
			echo CHtml::DropDownList('catalogTemplate', 'Select Template', CHtml::listData(CatalogTemplate::model()->findAll(), 'id', 'name'),array('class'=>'span4')); 
			echo '&nbsp';
		
             $this->widget('bootstrap.widgets.TbButton',array(
                'label' => 'Load Template',
                'size' => 'medium',
                'icon' =>'icon-share',
                'htmlOptions'=>array('class'=>'btn-secondary','name'=>'btnpromotell',
                    'id'=>'btn_cat_load_tag',
                    'rel'=>'tooltip',
                    )
            )); 
                
		$this->endWidget('bootstrap.widgets.TbActiveForm'); 

		?>
			</div>
		</div>
		<div id='templateDiv' class="marc-input"></div>
	
	
	
<?php $this->endWidget(); 
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'marc-leader-lmDialog',
                
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Marc Leader'),
                                'width'=>'500',
                                'height'=>'520',
                                'autoOpen'=>false,
                                'position'=>array('my'=>'top+60','at'=>'center','of'=>'.navbar'),
                                'modal'=>true,
                                'resizable'=>false,
                                'draggable'=>true,
								 
                                ),
                        ));

						
	//echo $this->renderPartial('_leader', array());   	
		
?>
	<div class="divForForm"></div>
<?php					
	$this->endWidget();						
?>						


<?php
Yii::app()->clientScript->registerScript('show_tag',"
    window.showMarcTag = window.showMarcTag || {};
    if (!window.showMarcTag.showMarcTag) 
    {
        window.showMarcTag.liveClickHandlerAttached = true;
        $(document).on('click', '#btn_cat_load_tag', function(event)
        {
            Loading.show();
            var templateID = $('#catalogTemplate').val();
           
            {jQuery.ajax(
                {'id':'sent',
                type:'POST',
                data: {catalogTemplate: templateID},
                url:'/catalog/rendercatalogtemplate/',
                cache:false,
                success:function(html)
                    {
                        $('#ajax-status').removeClass('ajax_loading');
                        $('#templateDiv').html(html);
                                                         
                    }
                });
                Loading.hide();   
                return false;
                }
            
         
         
        
        });
    }
");

?>
 <?php
Yii::app()->clientScript->registerScript('save_Marc',"
    window.saveMarc = window.saveMarc || {};
    if (!window.saveMarc.liveClickHandlerAttached) {
        window.saveMarc.liveClickHandlerAttached = true;
    $(document).on('click', '.btnsaveMarc', function(elem)
        
        {
            //var _name  = $(elem).attr('name');           
            return validateMarc();
                
            
            {jQuery.ajax(
                {
                    type:'POST',
                    data: $('#marc-form').serialize() + '&'+ _name + '=1',
                    url: '/catalog/SaveMarc/',
                    cache:false,
                    dataType: 'json',
                    success:function(data)
                    {
                        $.lmNotify(data);
                        
                    },
                    error : function(data)
                    {
                        $.lmNotify(data);
                    }
                }
                );return false;
            }
        
        
        });
    }
    function validateMarc()
    {
        var ret = true;
        var msg = 'Please enter the following information:\\n'
        $('input[type=text]:required').each(function()
        {
            
            if(!$.trim(this.value).length)
            
            {
                var _id = $(this).attr('id');
                
                var tag = _id.substring(5,8);
                var sf = _id.substring(9,10);
                msg += '    Tag ' + tag + ' subfield ['+ sf + ']\\n'; 
                
                ret = false;
            }
            if (!ret)
                bootbox.alert(msg);
            return ret;
        
        })
        
    
    }

");

?>
