<?php
$this->breadcrumbs=array(
	'Good Receives'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GoodReceive','url'=>array('index')),
	array('label'=>'Create GoodReceive','url'=>array('create')),
	array('label'=>'View GoodReceive','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage GoodReceive','url'=>array('admin')),
);
?>

<h1>Update GoodReceive <?php echo $model->id; ?></h1>
<?php
	$this->widget('extcommon.lmwidget.LmJgrowl', array('form' => $model, 'flash' => '')); 
?>
<?php
	$summary = $this->renderPartial('_form',array('model'=>$model),true);
	$poItem = $this->renderPartial('_po_item',array('model'=>$model,'poList'=>$poList),true);
	$invItem = '';
	
	$this->beginWidget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'tabs'=>array(
			array('label'=>'Summary', 'content'=>$summary, 'active'=>true),
			array('label'=>'Purchase Order Item', 'content'=>$poItem),
			array('label'=>'Invoice Item', 'content'=>$invItem),
			
		),
	));

$this->endWidget();
?>

