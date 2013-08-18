<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model)); 

?>
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Upsdate Catalog Item",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
	
	));
	
?>

			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'catalog-item-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal' ));
			
				$this->widget('bootstrap.widgets.TbTabs', array(
					'type'=>'tabs', // 'tabs' or 'pills'
					'tabs'=>array(
						array('label'=>'Acession Info', 
							  'content'=>$this->renderPartial('_form',array('form'=>$form,'model'=>$model),true),'active'=>true),
						array('label'=>'Accounting', 
							  'content'=>$this->renderPartial('_accounting',array('form'=>$form,'model'=>$model),true)),
						array('label'=>'Related Copies','content'=>'TODO'),
		
					),
				));	

			
			 ?>
			
				
		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
		</div>
	
				
<?php $this->endWidget(); //form
		$this->endWidget(); //lmbox
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'ctlLookupDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'',
        'autoOpen'=>false,
        'width'=>'500',
		'height'=>'300',
        
        'position'=>array('my'=>'right top','at'=>'right bottom','of'=>'#ctl_lookup'),
        'modal'=>true,
        'closeOnEscape'=>true,
        'resizable'=>false,
    ),
));

    $this->renderPartial('_catalogsearch');
	
?>
<div class="divForForm"></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>



<script type="text/javascript">
  $(document).ready(function()
    {
         
        $('#ctlLookupDialog').niceScroll('#ctlLookupDialog .divForForm',{boxzoom:true,cursorwidth:10});  // hw acceleration enabled when using wrapper
       
        
    });
    function searchCatalog()
	{
		
        {jQuery.ajax(
            {'id':'sent',
            type:'POST',
            dataType : 'json',
            data: $('#searchCatalogForm').serialize(),
            url:'/catalog/search/',
            cache:false,
            success:function(data)
                {

                    $('#ctlLookupDialog div.divForForm').html(data.div);
					
                }
                
            }
            );
            
            return false;}

        
        
        
		
	}
  
    
    
   
  
   
    
</script>

<?php
Yii::app()->clientScript->registerScript('selCat',"
 
    window.selCatalog = window.selCatalog || {};
    if (!window.selCatalog.liveClickHandlerAttached) 
    {
        window.selCatalog.liveClickHandlerAttached = true;
        $(document).on('click', '.selectCatalog', function(event)
        {
            event.preventDefault();
            var cn = $(this).attr('href');
            
            $('#CatalogItem_control_number').val(cn);
            $('#ctlLookupDialog').dialog('close');   
            return false;
            
       
             
        });
    }
    
");


?>
