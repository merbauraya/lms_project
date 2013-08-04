<?php  
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>


<?php

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Checkout",
		//'headerIcon' => 'icon-user',
		//'content' => $this->renderPartial('_checkoutform',array('model'=>$model),true),
	));
    $this->beginWidget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>array(
                    array('id'=>'tabCheckout','label'=>'Checkout', 'content'=>$this->renderPartial('_checkoutform',array('model'=>$model),true), 'active'=>true),
                    array('id'=>'tabPatron','label'=>'Patron Info', 'content'=>$this->renderPartial('_patroninfo',array('model'=>$model),true)),
                    array('id'=>'tabHolding','label'=>'Honding Info', 'content'=>'Content'),
		
                ),
                'events'=>array('shown'=>'js:loadTabs'),
));
    
    
	
	$this->endWidget();
	$this->endWidget();
?>
<?php
Yii::app()->clientScript->registerScript('_patron', "
    function loadTabs(e)
    {
        console.log(e.target);
        var tabId = e.target.getAttribute('href');
        if (tabId == '#tabPatron')
            loadPatronInfo(tabId);
        if (tabId == '#tabHolding')
            loadHoldingInfo(tabId);
    }

    function loadPatronInfo(tabId)
    {
        jQuery.ajax({
        'id' : 'loadPoItem',
        'type' : 'GET',
        'dataType': 'html',
        'data': {username: $('#CirculationTrans_patron_username').val()},
        'url' : '/patron/ViewByUsername/',
        'cache' : false,
        'success' : function(data)
          {
           
            $(tabId).html(data);
            console.log(data);
           
         
          }
        });
    } 
    function loadHoldingInfo(tabId)
    {
        jQuery.ajax({
        'id' : 'loadPoItem',
        'type' : 'GET',
        'dataType': 'html',
        'data': {username: $('#CirculationTrans_patron_username').val()},
        'url' : '/circulation/ViewUserHolding/',
        'cache' : false,
        'success' : function(data)
          {
           
            $(tabId).html(data);
            console.log(data);
           
         
          }
        });
     
    }
");
 
?>
