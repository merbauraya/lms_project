<?php
/**
 * _po_item.php
 *
 * @author: mazlan mat <mazlan.mat@gmail.com
 
 */

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'good-receive-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); 
?>
	<div class="control-group">
		<label for="GoodReceive_po_text_id" class="control-label">Po Text Id</label>
		<div class="controls">
			<?php
				$this->widget('bootstrap.widget.TbSelect2', array(
				'asDropDownList'=>true,
				'id'=>'GoodReceive_po_text_id',
				'name'=>'GoodReceive[po_text_id]',
				'data'=>CHtml::listData($poList,'id','text_id'),
				));
			echo "&nbsp;";
			$this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Load Item',
			'type' => 'primary',
			'size' => 'medium',
			'htmlOptions' => array('id'=>'_btnLoadPoItem',),
			));	 ?>
		</div>
	</div>	

	
<?php	
	
	$this->endWidget(); 

?>
<div id="div_po_item">

</div>
<?php
$_url = Yii::app()->createUrl('goodreceive/loadPoItem');
Yii::app()->clientScript->registerScript('sc_load_po_item',"
$('body').on('click','#_btnLoadPoItem',function(){

	var _url = '" . $_url ."' ;
	var _poId = $('#GoodReceive_po_text_id').val();

	_url += _poId;
	jQuery.ajax({
		'id' : 'loadPoItem',
		'data': {rID: $model->id},
		'url' : _url,
		'cache' : false,
		'success' : function(html)
			{jQuery('#div_po_item').html(html)}});
		
		return false;	
});

")


?>
