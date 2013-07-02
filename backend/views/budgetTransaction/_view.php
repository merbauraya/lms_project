<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->budget_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_id')); ?>:</b>
	<?php echo CHtml::encode($data->library_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_code')); ?>:</b>
	<?php echo CHtml::encode($data->trans_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_date')); ?>:</b>
	<?php echo CHtml::encode($data->trans_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trans_amount')); ?>:</b>
	<?php echo CHtml::encode($data->trans_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget_source_id')); ?>:</b>
	<?php echo CHtml::encode($data->budget_source_id); ?>
	<br />

	*/ ?>

</div>