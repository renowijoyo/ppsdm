<?php
/* @var $this ProfileController */
/* @var $model Profile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'place_of_birth_id'); ?>
		<?php echo $form->textField($model,'place_of_birth_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'place_of_birth_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'gender_id'); ?>
		<?php echo $form->textField($model,'gender_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'gender_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'religion_id'); ?>
		<?php echo $form->textField($model,'religion_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'religion_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'nationality_id'); ?>
		<?php echo $form->textField($model,'nationality_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nationality_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'ethnicity_id'); ?>
		<?php echo $form->textField($model,'ethnicity_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ethnicity_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'marriage_status_id'); ?>
		<?php echo $form->textField($model,'marriage_status_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'marriage_status_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'number_of_children'); ?>
		<?php echo $form->textField($model,'number_of_children'); ?>
		<?php echo $form->error($model,'number_of_children'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->