

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
<div class="tb_input">

        <div class="grid-view">
            <table class="templateFrame" cellspacing="0" width="100%">
                <thead class="templateHead">
                    <tr>
						
						<th>
							Author
						</th>
                        <th> 
                            Title
                        </th>
                        <th>ISBN/ISSN</th>
						<th>Publisher</th>
						<th>Year</th>
						<th>Edition</th>
						<th>Copies</th>
						<th>Currency</th>
						<th>Price</th>
						<th></th>
						<th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="11">
                            <div class="add"><?php echo Yii::t('ui','New');?></div>
								<textarea class="template" rows="0" cols="0">
                                <tr class="templateContent">
                                    <td>
									
									<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][author]','',array('class'=>'tbspan')); 
									echo CHtml::hiddenField('AcquisitionSuggestionItem[{0}][acq_suggestion_id]',$model->id);
									echo CHtml::hiddenField('AcquisitionSuggestionItem[{0}][id]','0');
									?>
									
									</td>
									
									<td><?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][title]','',array('class'=>'tbspan')); ?>
										
									</td>
									<td>
									<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][isbn]','',array('class'=>'span5')); ?>
									
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][publisher]','',array('class'=>'span5')); ?>
										
										
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][year]','',array('class'=>'span5')); ?>
										
										
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][edition]','',array('class'=>'span5')); ?>
										
										
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][copy]','',array('class'=>'span5')); ?>
										
										
									</td>
									<td>
										<?php 
										echo CHtml::dropDownList('AcquisitionSuggestionItem[{0}][currency_id]','',CHtml::listData(Currency::model()->findAll(), 'id', 'name'),array('prompt'=>'Select Currency','class'=>'inventory'));

										?>
									</td>
									<td>
										<?php echo CHtml::textField('AcquisitionSuggestionItem[{0}][price]','',array('class'=>'span5')); ?>
										
										
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
					<?php foreach($items as $i=>$item): ?>
					<?php if($item)
					{ //only if we have existing item 
						echo '<tr class="templateContent">';
						echo '<td>' ;
						echo $form->hiddenField($item,"[$i]id"); 
						
						echo $form->textField($item,"[$i]author",array('class'=>'tbspan3')); 
						
						echo '</td>'; //author
						
						echo '<td> ';
						echo $form->textField($item,"[$i]title",array('class'=>'span4')); 
						echo '</td>'; //title
						echo '<td>';	
						
						echo $form->textField($item,"[$i]publisher",array('class'=>'span4')); 
						echo '</td>'; //publisher
						echo '<td>';	
						
						echo $form->textField($item,"[$i]isbn",array('class'=>'span4')); 
						echo '</td>'; //isbn
						echo '<td>'; 
						echo $form->textField($item,"[$i]year",array('class'=>'span5')); 
						echo '</td>'; //year
						echo '<td>'; 
						echo $form->textField($item,"[$i]edition",array('class'=>'span5')); 
						echo '</td>'; //edition
						echo '<td>'; 
						echo $form->textField($item,"[$i]copy",array('class'=>'span5')); 
						echo '</td>';//copies
						echo '<td>'; 
						echo $form->dropDownList($item,"[$i]currency_id",
							 CHtml::listData(Currency::model()->findAll(), 'id', 'name'),
							 array('prompt'=>'Select Currency','class'=>'currency'));	
							
						echo '</td>';//currency
						echo '<td>'; 
						echo $form->textField($item,"[$i]price",array('class'=>'span5')); 
						echo '</td>';//price
						
						echo '<td>';
						echo CHtml::image(Yii::app()->baseUrl."/img/delete.png",'Delete',array("class"=>"remove",'title'=>'Delete Row')); 
							
						echo '</td>';
						echo '</tr>'; } ?>
					 
				<?php endforeach; ?>
                </tbody>
            </table>
        </div><!--gridview-->
    </div><!--tbinput-->
<?php
	echo CHtml::link('open dialog', '#', array(
   'onclick'=>'$("#itemDialog").dialog("open"); return false;',
)); ?>
 <div class="action">
		<?php echo CHtml::submitButton(Yii::t('ui','Submit')); ?>
</div>
 <?php $this->endWidget(); ?>
 <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'itemDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Suggestion Item',
        'autoOpen'=>false,
        'width'=>'auto',
        'modal'=>true,
    ),
));
	$itemModel = new AcquisitionSuggestionItem();
	$itemModel->acq_suggestion_id = $sID;
	$this->renderPartial('_form_item_popup',array('model'=>$itemModel,'sID'=>$sID));
?>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


 
 
 
 


