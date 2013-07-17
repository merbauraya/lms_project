



<?php
    
    echo CHtml::tag('div',array(
                    'id'=>$tag .'-subfield-sf',
                    'class'=>'row-fluid marc-subfield'),'',false);
    
    foreach ($model as $rec)
    {
        //start our subfield row
        echo CHtml::tag('div',array(
                    'id'=>$rec['tag'] .'-'. $rec['subfield'].'-sf',
                    'class'=>'row-fluid marc-subfield'),'',false
		);
        
        
        //$linkId = $tag.'-'.$subfield->subfield.'-id'.$counter;
        echo CHtml::tag('span',array('style'=>'padding-left:10px;'),'',false);
        $ckName = 'Marc['.$rec['tag'].'-'.$rec['subfield'].'-sck]';
        echo CHtml::checkBox($ckName,false,array());
        
        echo '['.$rec['subfield'] .'] ' . $rec['subfield_name'];
        //$buffer .='&nbsp;'. generateLink('Delete Subfield','delete-subfield','icon-remove',null,$linkId);
        echo CHtml::closeTag('span'); //subfield
        echo CHtml::closeTag('div'); //subfield
        
    }
echo CHtml::closeTag('div'); //subfield
