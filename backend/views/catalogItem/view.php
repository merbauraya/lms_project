
<?php  


$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>

<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "View Accession",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
	
	));
	


    $this->widget('extcommon.lmwidget.AjaxTabs', array(
					'type'=>'tabs', // 'tabs' or 'pills'
					'tabs'=>array(
						array('label'=>'Acession Info', 
							  'content'=>$this->renderPartial('_viewaccession',array('model'=>$model),true),'active'=>true),
						array('label'=>'Accounting', 
							  'content'=>$this->renderPartial('_viewaccounting',array('model'=>$model),true)),
						array('label'=>'Related Copies','content'=>'loading...',
                              'linkOptions' => array('data-tab-url' => Yii::app()->createUrl('CatalogItem/RelatedCopy',array('cn'=>$model->control_number,'aid'=>$model->id)))
                        ),
		
					),
				));	




$this->endWidget('extcommon.lmwidget.LmBox');
?>
		
