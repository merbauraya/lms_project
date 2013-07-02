<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acquisition_suggestion_id')); ?>:</b>
	<?php echo CHtml::encode($data->acquisition_suggestion_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_sent')); ?>:</b>
	<?php echo CHtml::encode($data->date_sent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_to')); ?>:</b>
	<?php echo CHtml::encode($data->send_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_sent')); ?>:</b>
	<?php echo CHtml::encode($data->url_sent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response')); ?>:</b>
	<?php echo CHtml::encode($data->response); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price_per_copy')); ?>:</b>
	<?php echo CHtml::encode($data->price_per_copy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('page_password')); ?>:</b>
	<?php echo CHtml::encode($data->page_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response_date')); ?>:</b>
	<?php echo CHtml::encode($data->response_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('due_date')); ?>:</b>
	<?php echo CHtml::encode($data->due_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_id')); ?>:</b>
	<?php echo CHtml::encode($data->currency_id); ?>
	<br />

	*/ ?>

</div>