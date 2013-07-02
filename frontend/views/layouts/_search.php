<div class="container">
<div class="row-fluid">
	<div class="span12">
		
		
			<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'inlineForm',
			'type'=>'inline',
			'action'=>Yii::app()->createUrl('opac/index'),
			'method'=>'get',
			'htmlOptions'=>array('class'=>'well'),
		)); ?>
	
			<div class="input-prepend">
				<span class="add-on">
				<i class="icon-search"></i></span>
				<input class="input-medium" placeholder="Enter your search" name="q" id=q" type="text" />
			</div>
			<?php echo CHtml::dropDownList('cat', '0', 
              array('0' => 'Anywhere', '1' => 'Title','2'=>'Subject','3'=>'Author')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit', 
				'label'=>'GO',
				'htmlOptions' => array('name'=>'go')
			)); ?>
 
			<?php $this->endWidget(); ?>
	
		
		
	</div>
</div>
</div>
	