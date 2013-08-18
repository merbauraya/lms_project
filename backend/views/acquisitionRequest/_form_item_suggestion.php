	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'acquisition-suggestion-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

<div class="control-group">
	<label class="control-label">Select Suggestion </label>
	<div class="controls">

<?php
echo CHtml::dropDownList('suggestion','',CHtml::listData($suggModel,'id','text_id'),array('class'=>'span3'));
echo '&nbsp';
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Load Suggestion Item',
	'type' => 'primary',
	'size' => 'medium',
	'htmlOptions' => array('id'=>'_btn_load_sugg_items',),
));


	
?>
	</div>
	
	
		
	
</div>
<?php $this->endWidget(); ?>
<div id="div_sugg_items">

</div>
<?php
$_url = Yii::app()->createUrl('acquisitionRequest/loadSuggestionItem');
Yii::app()->clientScript->registerScript('sc_load_sugg_item',"
$('body').on('click','#_btn_load_sugg_items',function(){

var _url = '" . $_url ."' ;
var _suggId = $('#suggestion').val();
console.log (_suggId);
_url += _suggId;
jQuery.ajax({
	'id' : 'loadSuggItem',
	'url' : _url,
	'cache' : false,
	'success' : function(html)
		{jQuery('#div_sugg_items').html(html)}});
	
	return false;	
});

")


?>
<input type="hidden" id="request_id" value="<?php echo $sID ?>">

	

