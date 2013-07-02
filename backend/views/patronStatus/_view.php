<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_checkout')); ?>:</b>
	<?php echo CHtml::encode($data->allow_checkout); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_checkin')); ?>:</b>
	<?php echo CHtml::encode($data->allow_checkin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_reserve')); ?>:</b>
	<?php echo CHtml::encode($data->allow_reserve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_backend_login')); ?>:</b>
	<?php echo CHtml::encode($data->allow_backend_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_opac_login')); ?>:</b>
	<?php echo CHtml::encode($data->allow_opac_login); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_renew')); ?>:</b>
	<?php echo CHtml::encode($data->allow_renew); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_comment')); ?>:</b>
	<?php echo CHtml::encode($data->allow_comment); ?>
	<br />

	*/ ?>

</div>