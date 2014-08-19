<?php
/* @var $this ProfileController */
/* @var $data Profile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_birth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('place_of_birth_id')); ?>:</b>
	<?php echo CHtml::encode($data->place_of_birth_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender_id')); ?>:</b>
	<?php echo CHtml::encode($data->gender_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('religion_id')); ?>:</b>
	<?php echo CHtml::encode($data->religion_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nationality_id')); ?>:</b>
	<?php echo CHtml::encode($data->nationality_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ethnicity_id')); ?>:</b>
	<?php echo CHtml::encode($data->ethnicity_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('marriage_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->marriage_status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_children')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_children); ?>
	<br />

	*/ ?>

</div>