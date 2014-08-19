<?php
/* @var $this AssessmentController */
/* @var $model Assessment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assessment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_id'); ?>
		<?php echo $form->textField($model,'profile_id'); ?>
		<?php echo $form->error($model,'profile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_subject'); ?>
		<?php echo $form->textField($model,'tao_subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assessment_item_id'); ?>
		<?php echo $form->textField($model,'assessment_item_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'assessment_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_test'); ?>
		<?php echo $form->textField($model,'tao_test',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_test'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_test_label'); ?>
		<?php echo $form->textField($model,'tao_test_label',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_test_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_delivery_label'); ?>
		<?php echo $form->textField($model,'tao_delivery_label',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_delivery_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_delivery_result'); ?>
		<?php echo $form->textField($model,'tao_delivery_result',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_delivery_result'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tao_delivery_status'); ?>
		<?php echo $form->textField($model,'tao_delivery_status',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tao_delivery_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time'); ?>
		<?php echo $form->error($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'finish_time'); ?>
		<?php echo $form->textField($model,'finish_time'); ?>
		<?php echo $form->error($model,'finish_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'result_url'); ?>
		<?php echo $form->textField($model,'result_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'result_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'download_url'); ?>
		<?php echo $form->textField($model,'download_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'download_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->