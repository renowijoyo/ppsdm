<?php
/* @var $this AssessmentController */
/* @var $data Assessment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_id')); ?>:</b>
	<?php echo CHtml::encode($data->profile_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_subject')); ?>:</b>
	<?php echo CHtml::encode($data->tao_subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assessment_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->assessment_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_test')); ?>:</b>
	<?php echo CHtml::encode($data->tao_test); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_test_label')); ?>:</b>
	<?php echo CHtml::encode($data->tao_test_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_delivery_label')); ?>:</b>
	<?php echo CHtml::encode($data->tao_delivery_label); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_delivery_result')); ?>:</b>
	<?php echo CHtml::encode($data->tao_delivery_result); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tao_delivery_status')); ?>:</b>
	<?php echo CHtml::encode($data->tao_delivery_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_time')); ?>:</b>
	<?php echo CHtml::encode($data->finish_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('result_url')); ?>:</b>
	<?php echo CHtml::encode($data->result_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_url')); ?>:</b>
	<?php echo CHtml::encode($data->download_url); ?>
	<br />

	*/ ?>

</div>