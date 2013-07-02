<?php
$this->breadcrumbs=array(
	'Biblio Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BiblioItem','url'=>array('index')),
	array('label'=>'Manage BiblioItem','url'=>array('admin')),
);
?>
<?php  


$this->widget('extcommon.LmWidget.LmJgrowl', array('form' => $model, 'flash' => '')); 

?>
<?php
	$this->beginWidget('extcommon.lmwidget.LmBox', array(
		'title' => "Create Catalog Item",
		//'headerIcon' => 'icon-user',
		'content' => '',
		'btnHeaderDivClass' =>'lmboxBtn',
	
	));
	
?>

			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'catalog-item-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal' ));
			
				$this->widget('bootstrap.widgets.TbTabs', array(
					'type'=>'tabs', // 'tabs' or 'pills'
					'tabs'=>array(
						array('label'=>'Acession Info', 
							  'content'=>$this->renderPartial('_form',array('form'=>$form,'model'=>$model),true),'active'=>true),
						array('label'=>'Accounting', 
							  'content'=>$this->renderPartial('_accounting',array('form'=>$form,'model'=>$model),true)),
						array('label'=>'Related Copies','content'=>'TODO'),
		
					),
				));	

			
			 ?>
			
				
		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
		</div>
	
				
<?php $this->endWidget(); //form
		$this->endWidget(); //lmbox
?>


