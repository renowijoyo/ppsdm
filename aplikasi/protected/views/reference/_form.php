<?php
/* @var $this ReferenceController */
/* @var $model Reference */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reference-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'context'); ?>
		<?php echo $form->textField($model,'context',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'context'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reference_key'); ?>
		<?php echo $form->textField($model,'reference_key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'reference_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reference_value'); ?>
		<?php echo $form->textField($model,'reference_value',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'reference_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->