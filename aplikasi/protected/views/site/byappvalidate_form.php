

<p>Please validate your email</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'validate-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'validation_code'); ?>
		<?php echo $form->textField($model,'validation_code'); ?>
		<?php echo $form->error($model,'validation_code'); ?>
	</div>




	<div class="row buttons">
		<?php echo CHtml::submitButton('Validate'); ?>
	</div>
	<br/>
	<div>
		<a href="">Resend validation code (not implemented yet)</a>
	</div>
<?php $this->endWidget(); ?>
</div>
