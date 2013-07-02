<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Z3950 Search/Retrieve via URL (SRU)",
		//'headerIcon' => 'icon-user',
		'content' => '',
			'btnHeaderDivClass' =>'lmboxBtn',
		'headerButtons'=>array(
			 array(
	           'class' => 'bootstrap.widgets.TbButton',
			   'label'=>'Action ',
			   
	           'items' => array(  
								array('label'=>'Manage','url'=>array('admin')),
								array('label'=>'Create','url'=>array('create')),
								
			   
						),
	           'size' => 'small'
	         ),
		)
	));
	
?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'sru-form',
		'enableAjaxValidation'=>false,
		'type'=>'inline',
		'htmlOptions'=>array('class'=>'compact-form',
		                     'onsubmit'=>"return false;",/* Disable normal form submit */
                             'onkeypress'=>" if(event.keyCode == 13){ searchSRU(); } "), 
		
	)); ?>
		<div class="well">
		<?php echo CHtml::label('Search',false);?> 
		<?php echo CHtml::textField('keyword','');?>
		<?php
					echo CHtml::dropDownList('qtype','1',array(
						'0'=>'All Field',
						'bath.isbn'=>'ISBN/ISSN',
						'dc.title'=>'Title',
						'bath.name'=>'Authors'),	
						array('class'=>'span2')
						);
		?>
		<?php echo CHtml::label('Server',false);?> 
		<?php echo CHtml::dropDownList('server','',
					CHtml::listData($resource,'id','name'),array('class'=>'span3'));
		?>
		
		
		
			<?php echo CHtml::Button('Go',array('onclick'=>'searchSRU();',
					'class'=>'btn btn-primary')); ?> 		
		</div>
		<p id="ajax-status"></br></p>
		<div id="sru-result"></div>
		
	
	


	<?php $this->endWidget(); //form ?> 
<?php $this->endWidget(); //lmbox ?>
<script type="text/javascript">
	
	function searchSRU()
	{
		var _data = $("#sru-form").serialize();
		$("#ajax-status").addClass("ajax_loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("catalog/srusearch");  ?>',
			data : _data,
			dataType: 'html',
			success: function(data){
				$("#ajax-status").removeClass("ajax_loading");
				$("#sru-result").html(data);
			},
			error: function(data){
				$("#ajax-status").removeClass("ajax_loading");
				$("#sru-result").html('Error occured. Please try again');
			},
		});
	
	
	}


</script>