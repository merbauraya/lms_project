<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/opac'); ?>
<div class="span3">
	
<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items' => $this->menu,
	));

?>
		
</div>

<div class="span6">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span3">
	
<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items' => $this->menu,
	));

?>
		
</div>
<?php $this->endContent(); ?>