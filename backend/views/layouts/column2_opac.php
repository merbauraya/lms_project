<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/opac'); ?>
<div class="span2">
<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items' => $this->menu,
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
</div>

<div class="span8">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span2">
	
<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items' => $this->menu,
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
	
</div>
<?php $this->endContent(); ?>