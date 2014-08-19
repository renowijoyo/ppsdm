<?php
/* @var $this ReferenceController */
/* @var $data Reference */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('context')); ?>:</b>
	<?php echo CHtml::encode($data->context); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_key')); ?>:</b>
	<?php echo CHtml::encode($data->reference_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_value')); ?>:</b>
	<?php echo CHtml::encode($data->reference_value); ?>
	<br />


</div>