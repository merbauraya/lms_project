<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('catalog_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->catalog_id),array('view','id'=>$data->catalog_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accession_number')); ?>:</b>
	<?php echo CHtml::encode($data->accession_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_id')); ?>:</b>
	<?php echo CHtml::encode($data->library_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_id')); ?>:</b>
	<?php echo CHtml::encode($data->location_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('barcode')); ?>:</b>
	<?php echo CHtml::encode($data->barcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_number')); ?>:</b>
	<?php echo CHtml::encode($data->book_number); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('classification_number')); ?>:</b>
	<?php echo CHtml::encode($data->classification_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('call_number')); ?>:</b>
	<?php echo CHtml::encode($data->call_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('control_number')); ?>:</b>
	<?php echo CHtml::encode($data->control_number); ?>
	<br />

	*/ ?>

</div>