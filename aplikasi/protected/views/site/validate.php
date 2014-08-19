<?php
$this->pageTitle=Yii::app()->name . ' - Validate';
$this->breadcrumbs=array(
	'Validate',
);
?>

<h1><?php echo Yii::t('strings', '(Validate)');?></h1>

<p><?php echo Yii::t('strings', '(Please validate your email)');?></p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'validate-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="">
		<?php echo $form->labelEx($model,'validation_code'); ?>
		<?php echo $form->textField($model,'validation_code'); ?>
		<?php echo $form->error($model,'validation_code'); ?>
	</div>




	<div class="buttons">
		<?php echo CHtml::submitButton(Yii::t('strings', '(Validate)')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>





