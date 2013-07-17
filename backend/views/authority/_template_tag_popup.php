


<div id="sidebarx" style="float:right;position:fixed;top:60px;margin:0 0 0 470px">
			<?php
                  $this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Save',
	'size' => 'medium',
	'icon' =>'icon-ok',
    'htmlOptions'=>array('class'=>'btn-secondary','name'=>'btnpromotell',
		'id'=>'btn_save_subfield',
        'rel'=>'tooltip',
        )
)); 
   echo '&nbsp';
            
            ?>	
		  	
		
		</div>

<?php

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'template-tag',
		'type'=>'horizontal',
			
	)); 
	
?>


<?php
$tag='';
$n=0;
foreach ($model as $rec)
{    
        ++$n;
        startTag($rec['tag'],$rec['tag_name'],$n);
        endTag();
        //subfield wrapper
        
   
    
    //addSubfield($rec['tag'],$rec['subfield'],$rec['subfield_name']);
    
}
function startTag($tag,$name,$n)
{
    echo CHtml::tag('div',array(
                    'id'=>$tag.'-tp-'.$n ,
                    'class'=>'row-fluid marc-tag'),'',false);
    
    //echo CHtml::checkBox('Marc[tag-'.$tag.']',false,array('checked'=>false));
    echo '&nbsp;';
    echo CHtml::tag('span',array(
			'title'=>$name,
			), '['.$tag.'] ',true
		);
    echo CHtml::link($name,'#',array(
				'onclick'=>'toogleTag();'
			));
    
    if ((int)$tag>10)
        echo '&nbsp;' .generateLink('Show subfield','showTagSubfield','icon-list');
}
function endTag()
{
    echo CHtml::closeTag('div'); //span 12
    
}

function generateLink($title,$class,$icon='icon-edit',$click=null)
{
		$buffer = '';
		$linkIcon = CHtml::tag('i',array(
			'class'=>$icon
			)
		);
		
		$buffer = CHtml::link($linkIcon,'#',array(
			'title'=>$title,
			'class'=>$class,
            'rel'=>'tooltip',
			'onClick'=>$click,
		)	);
		return $buffer;
		
}

$this->endWidget();

?>

