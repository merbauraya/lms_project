<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span2 no-left-margin">
<!--
<aside>
-->
<?php
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => "Welcome " . Yii::app()->user->name,
    //'headerIcon' => 'icon-user',
    'content' => "Edit Profile"
	));
	?>
	
<div class="navbar-left-fixed">
	
	
<?php      /*
			$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items' => $this->menu,   *
	));

                                       */
$sidemenu = array(
		
			 		array('label'=>'Cataloging','url'=>'#','items'=>array(
					array('label'=>'New Catalog','icon'=>'icon-search','url'=>
					array('catalog/create')),
					array('label'=>'New Item','url'=>array('catalog/createitem')),
					array('label'=>'Search','url'=>array('catalog/search')),
					
					array('label'=>'Invoice Entry','url'=>array('invoice/create')),
					
					)
			
	
					
					),
				array('label'=>'Acquisition','url'=>'#','items'=>array(
					array('label'=>'New Suggestion','icon'=>'icon-search','url'=>
					array('acquisitionsuggestion/precreate')),
					array('label'=>'List Suggestion','url'=>array('acquisitionsuggestion/index')),
					array('label'=>'New Request','url'=>array('acquisitionsuggestion/index')),
					
					array('label'=>'Invoice Entry','url'=>array('invoice/create')),
					
					)
			
	
					
					),
				
					
					
				array('label'=>'Request','icon'=>'icon-search','url'=>'#','items'=>array(
					array('label'=>'New Request','url'=>
					array('acquisitionrequest/precreate')),
					array('label'=>'List Request','url'=>array('acquisitionrequest/index')),
					
					array('label'=>'Request Approval','url'=>array('acquisitionrequest/approvallist')),
					)),
					array('label'=>'Request','icon'=>'icon-search','url'=>'#','items'=>array(
					array('label'=>'New Request','url'=>
					array('acquisitionrequest/precreate')),
					array('label'=>'List Request','url'=>array('acquisitionrequest/index')),
					
					array('label'=>'Request Approval','url'=>array('acquisitionrequest/approvallist')),
					)),
					array('label'=>'Request','icon'=>'icon-search','url'=>'#','items'=>array(
					array('label'=>'New Request','url'=>
					array('acquisitionrequest/precreate')),
					array('label'=>'List Request','url'=>array('acquisitionrequest/index')),
					
					array('label'=>'Request Approval','url'=>array('acquisitionrequest/approvallist')),
					)),


);	

//$lmenu  = array_merge($this->sidemenu,$sidemenu);
	
$this->widget('extcommon.lmwidget.LmAccMenu',array(
	'items'=>$sidemenu

));


?>
	<?php /*
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget(); */
	?>
	
</div> <!--span3-->
<!--</aside> -->
</div>
<div class="span10">
	
		<?php echo $content; ?>
	
	</div><!-- content -->

<?php $this->endContent(); ?>
