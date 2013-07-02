<script type="text/javascript">

$(document).ready(function() {

    //if submit button is clicked
    $('form#upload_marc').submit(function(){  

		
		$('#upload_wrapper').hide();
		$('#loading').show();
		
		// get the uploaded file name from the iframe
		$('#upload_target').unbind().load( function(){								
		var img = $('#upload_target').contents().find('#filename').html();
		//alert(img);
		var hsrc=$('#upload_target').contents().find('body').html();
		//alert(hsrc);
		 
		 $('#marcUploadView').html(hsrc);    //($('#upload_target').html());//     ($('#upload_target').html));
		//$('#marcView').html($('#upload_target').html);
		$('#loading').hide();


		});
		
	});
});

</script>
<div id="upload_wrapper">	
<?php

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'upload_marc',
		'type'=>'horizontal',
		'action'=>array('catalog/uploadMarc'),
		'htmlOptions' => array('enctype' => 'multipart/form-data','target'=>'upload_target'),
	)); 
	
?>	

	<div class="control-group">
		<div class="controls">
			<label for="MarcUpload_file_name">File Name</label>
			
			<input id="MarcUpload[0]" type="file" name="MarcUpload[0]">
			<input type="hidden" name="MarcUpload[zz]">
		</div>
	</div>
	 <div class="form-actions">
	 	<?php
			$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
		
	 </div>
	<?php
	echo CHtml::ajaxSubmitButton('Edit Marc Record',array('uploadMarc'),array('update'=>'#marcView','id'=>'sent'));
	
	$this->endWidget(); 
	?>
</div>	
<div id="loading" style="height:50px; width:370px; display:none;">
  <p style="margin-left:40px; padding-top:15px;">Uploading File... Please wait</p>
</div>
<div id="marcUploadView"></div>
<iframe id="upload_target" name="upload_target" style="width:10px; height:10px; display:none"></iframe>