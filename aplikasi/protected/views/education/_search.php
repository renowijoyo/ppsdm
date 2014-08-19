<?php
/* @var $this EducationController */
/* @var $model Education */
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
		<?php echo $form->label($model,'institution_id'); ?>
		<?php echo $form->textField($model,'institution_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_year'); ?>
		<?php echo $form->textField($model,'start_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'graduate_year'); ?>
		<?php echo $form->textField($model,'graduate_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->