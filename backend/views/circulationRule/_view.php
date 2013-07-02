<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_id')); ?>:</b>
	<?php echo CHtml::encode($data->library_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('patron_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->patron_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('smd_id')); ?>:</b>
	<?php echo CHtml::encode($data->smd_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loan_period')); ?>:</b>
	<?php echo CHtml::encode($data->loan_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_count_limit')); ?>:</b>
	<?php echo CHtml::encode($data->item_count_limit); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('period_type')); ?>:</b>
	<?php echo CHtml::encode($data->period_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fine_per_period')); ?>:</b>
	<?php echo CHtml::encode($data->fine_per_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_renewal_count')); ?>:</b>
	<?php echo CHtml::encode($data->max_renewal_count); ?>
	<br />

	*/ ?>

</div>