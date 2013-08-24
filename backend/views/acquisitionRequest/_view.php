<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_by')); ?>:</b>
	<?php echo CHtml::encode($data->requested_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_date')); ?>:</b>
	<?php echo CHtml::encode($data->request_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('budget_id')); ?>:</b>
	<?php echo CHtml::encode($data->budget_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_id')); ?>:</b>
	<?php echo CHtml::encode($data->library_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_mode_id')); ?>:</b>
	<?php echo CHtml::encode($data->request_mode_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_date')); ?>:</b>
	<?php echo CHtml::encode($data->approved_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rejected_by')); ?>:</b>
	<?php echo CHtml::encode($data->rejected_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rejected_reason')); ?>:</b>
	<?php echo CHtml::encode($data->rejected_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rejected_date')); ?>:</b>
	<?php echo CHtml::encode($data->rejected_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expected_purchase_date')); ?>:</b>
	<?php echo CHtml::encode($data->expected_purchase_date); ?>
	<br />

	*/ ?>

</div>
