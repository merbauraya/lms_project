

<?php
/* @var $this InvoiceItemController */
/* @var $model InvoiceItem */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.format.js');
?>

<script type="text/javascript">
	/**
 * jQuery script for adding new content from template field
 *
 * NOTE!
 * This script depends on jquery.format.js
 *
 * IMPORTANT!
 * Do not change anything except specific commands!
 */
jQuery(document).ready(function(){
	var lastID;
	hideEmptyHeaders();
	$(".datepick").datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy'});
	/*
	$("input.vendor_code").on("click", function() {
	    alert('zz');
		return false;
});​
	*/
	$("input.vendor_code").live("click", function(){
		var lastID = $(this).attr('id');
		$("#row_id").val(lastID);
		
		$("#vendor_dialog").dialog("open"); 
			
		return false;	
	});
	$(".add").click(function(){
		
		 $(".datepick").datepicker("destroy");
		var template = jQuery.format(jQuery.trim($(this).siblings(".template").val()));
		
		var place = $(this).parents(".templateFrame:first").children(".templateTarget");
		var i = place.find('tr').length > 0 ? place.find('tr').length +1: 0;
		//alert(x);
		
		$(template(i)).appendTo(place);
		 $(".datepick").datepicker({'showAnim':'fold','dateFormat':'dd/mm/yy'});
		place.siblings('.templateHead').show()
		
		
	});

	$(".remove").live("click", function() {
		$(this).parents(".templateContent:first").remove();
		hideEmptyHeaders();
	});
	
	$("input.plc_holder").change(function(){
		var venid = $("#vencode_plc_hldr").val();
		var rkey = $("#row_id").val();
		//rkey = rkey.replace('[','\\\\[');
		//rkey = rkey.replace(']','\\\\]');
		//alert (rkey);
		$("#"+ jqSelector(rkey)).val(venid);
		//$("#vendor\\[0\\]").val(venid);
//		return str.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1');
		
		
	});
	 $(".inventory").live ("change",function () {
		//alert('q');
		//get selected text from inventory
		$ivSelected = $(this).find('option:selected').text();
		if ($ivSelected=='Not Assigned')
			$ivSelected='';
		//alert(ivSelected);
		$curID = $(this).attr('id');
		//alert (curID);
		$sID = $curID.match(/\d+/g);
		$('#InvoiceItem_'+ $sID + '_item_name').val($ivSelected);
		
	 });
});

function hideEmptyHeaders(){
	$('.templateTarget').filter(function(){return $.trim($(this).text())===''}).siblings('.templateHead').hide();
}
function jqSelector(str)

{

	return str.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1');

}
</script>




<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-vendor-rfq-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="complex">
        <span class="label">
            
        </span>
        <div class="grid-view">
            <table class="templateFrame" cellspacing="0" width="100%">
                <thead class="templateHead">
                    <tr>
						<th>
							Vendor
							<input type="hidden" id="vencode_plc_hldr" class="plc_holder"></input>
							<input type="hidden" id="venid_plc_hldr"></input>
							<input type="hidden" id="venname_plc_hldr"></input>							<input type="hidden" id="row_id"></input>
						</th>
						<th>
							Email
						</th>
                        <th> 
                            Due Date
                        </th>
                        <th>Note</th>
						<th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="add"><?php echo Yii::t('ui','New');?></div>
								<textarea class="template" rows="0" cols="0">
                                <tr class="templateContent">
                                    <td>
									<input type="text" class="vendor_code" id="vendor[{0}]"></input>
									
									<?php /*echo CHtml::textField('AcquisitionSuggestionVendorRFQ[{0}][vendor_code]','',array('class'=>'span5','onclick'=>'$("#vendor_dialog").dialog("open"); return false;',));  */ ?>
									<?php
									/*echo CHtml::Button('...',
						array('onclick'=>'$("#vendor_dialog").dialog("open"); return false;',));
									
									*/ ?></td>
									
									<td><?php echo CHtml::textField('AcquisitionSuggestionVendorRFQ[{0}][send_to]','',array('class'=>'span5')); ?></td>
									<td>
									<?php	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>"AcquisitionSuggestionVendorRFQ[{0}][item_date]",
	
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
		'dateFormat' => 'dd/mm/yy', // save to db format
    ),
    'htmlOptions'=>array(
        'style'=>'height:10px;width:100px;',
		'class'=>'datepick'
    ),
));?>
									
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionVendorRFQ[{0}][note]','',array('class'=>'span5')); ?>
										
										
									</td>
									
									
                                    
                                   
									
									<td class="button-column">
									
									<?php echo CHtml::image(Yii::app()->baseUrl."/img/delete.png",'Delete',array("class"=>"remove","cursor"=>"pointer")); ?>
									
                                    <input type="hidden" class="rowIndex" value="{0}" />
									</td>
                                </tr>
                            </textarea>
                        </td>
                    </tr>
                </tfoot>
               <tbody class="templateTarget">
					<?php foreach($rfq as $i=>$item): ?>
					
							
					
					<?php if($item)
					{ //only if we have existing item
					echo '<tr class="templateContent">';
					echo '<td>' ;
					echo $form->hiddenField($item,"[$i]id"); 
					echo $form->textField($item,"[$i]vendor_code",array('class'=>'span3')); 
					
					echo '</td>'; //vendor code 
					
					echo '	<td> ';
					echo $form->textField($item,"[$i]send_to",array('class'=>'span4')); 
					echo '</td>'; //send to (email)
					echo '<td>';	
						
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>"[$i]due_date",
	'model'=>$item,
    'attribute'=>"[$i]due_date",
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
		'dateFormat' => 'dd/mm/yy', // save to db format
    ),
    'htmlOptions'=>array(
        'style'=>'width:100px;'
		
    ),
));
						echo '</td>';
						
						
								
						
						echo '<td>'; 
						echo $form->textField($item,"[$i]note",array('class'=>'span5')); 
						echo '</td><td>';
						echo CHtml::image(Yii::app()->baseUrl."/img/delete.png",'Delete',array("class"=>"remove",'title'=>'Delete Row')); 
							
						echo '</td>';
						
						
					echo '</tr>' ;} ?>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div><!--panel-->
    </div><!--complex-->
 <div class="action">
		<?php echo CHtml::submitButton(Yii::t('ui','Submit')); ?>
	</div>
 <?php $this->endWidget(); ?>
 
 
 
 
 


