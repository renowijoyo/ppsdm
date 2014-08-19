<?php
/* @var $this AssessmentController */
/* @var $model Assessment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile_id'); ?>
		<?php echo $form->textField($model,'profile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_subject'); ?>
		<?php echo $form->textField($model,'tao_subject',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assessment_item_id'); ?>
		<?php echo $form->textField($model,'assessment_item_id',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_test'); ?>
		<?php echo $form->textField($model,'tao_test',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_test_label'); ?>
		<?php echo $form->textField($model,'tao_test_label',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_delivery_label'); ?>
		<?php echo $form->textField($model,'tao_delivery_label',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_delivery_result'); ?>
		<?php echo $form->textField($model,'tao_delivery_result',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tao_delivery_status'); ?>
		<?php echo $form->textField($model,'tao_delivery_status',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'finish_time'); ?>
		<?php echo $form->textField($model,'finish_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'result_url'); ?>
		<?php echo $form->textField($model,'result_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'download_url'); ?>
		<?php echo $form->textField($model,'download_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->