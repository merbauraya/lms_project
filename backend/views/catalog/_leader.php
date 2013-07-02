<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marc-leader-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); 

	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "000 Marc Leader",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
		'htmlContentOptions'=>array('class'=>'popup'),
	
	));
	echo generateRow('[1-4] Record Size','(auto filled)','label');
	$data = Lookup::getLookupOptions(Lookup::MARC_RECORD_STATUS,false);
	
	
	echo generateRow('[5] Record Status','recordstatus','dropdown',$data,'n');
	$data = Lookup::getLookupOptions(Lookup::MARC_TYPE_OF_RECORD,false);
	echo generateRow('[6] Type of Record','typeofrecord','dropdown',$data,'a');
	$data = Lookup::getLookupOptions(Lookup::MARC_BIBLIO_LEVEL,false);
	echo generateRow('[7] Bibliographic Level','bibliographiclevel','dropdown',$data,'m');
	$data = Lookup::getLookupOptions(Lookup::MARC_TYPE_OF_CONTROL,false);
	echo generateRow('[8] Type of Control','typeofcontrol','dropdown',$data,'m');
	echo generateRow('[9] Character coding scheme','a - UCS/Unicode (auto filled)','label');
	echo generateRow('[10-16] indicator/subfields/size','(auto filled)','label');
	
	$data = Lookup::getLookupOptions(Lookup::MARC_ENCODING_LEVEL,false);
	echo generateRow('[17] Encoding Level','encodinglevel','dropdown',$data,'7');
	$data = Lookup::getLookupOptions(Lookup::MARC_DESC_CATALOG_FORM,false);
	echo generateRow('[18] Descriptive cataloging form','descriptivecatalogform','dropdown',$data,'a');
	$data = Lookup::getLookupOptions(Lookup::MARC_MULTIPART_RES_REC_LEVEL,false);
	echo generateRow('[19]  Multipart resource record level','multipartresourcerecord','dropdown',$data,'#');
	echo generateRow('[20-24] entry map & lengths','(auto filled)','label');
	
	
	$this->endWidget(); //lmbox	


?>

<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Ok',
		)); 	
		?> &nbsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Cancel',
		)); 	
		?>
	</div>


<?php $this->endWidget(); 

function generateRow($label,$for,$controlType,$data=array(),$selectedValue=null)
{
	$buffer = CHtml::tag('div',array(
				
				'class'=>'control-group'),'',false
		); //
	
	$buffer .= CHtml::label($label,$for,array(
		'class'=>'control-label',
	));
	$buffer .= CHtml::tag('div',array(
				
				'class'=>'controls'),'',false
	);
	switch ($controlType)
	{
		case 'dropdown':
			$buffer .= CHtml::dropdownList('Marc['.$for.']',$selectedValue,$data,array(
				'class'=>'span3',
			
			));
			break;
		
		case 'text':
			break;
			
		case 'label':
			$buffer .=CHtml::tag('span',array(),$for);
			break;
	
	
	}
	$buffer .= CHtml::closeTag('div');
	$buffer .= CHtml::closeTag('div');
	return $buffer;
}

?>


