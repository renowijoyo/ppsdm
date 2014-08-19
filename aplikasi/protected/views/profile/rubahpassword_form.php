<?php
/* @var $this ProfileController */
/* @var $model Profile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rubahpassword-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>



	<?php echo $form->hiddenField($model,'username'); ?>
	<div class="">
			<div class="label_name_column"><label for="current_password">current password</label></div>
			
				<?php echo $form->textField($model,'current_password'); ?>
						
	</div>
	<div class="">
		<div class="label_name_column">	<label for="new_password">new password</label></div>

			<?php echo $form->textField($model,'new_password'); ?>

	</div>
	<div class="">
		<div class="label_name_column"><label for="confirm_new_password">confirm new password</label></div>

				<?php echo $form->textField($model,'confirm_new_password'); ?>
	</div>

					<?php $form->error($model,'current_password'); ?>
					<?php $form->error($model,'new_password'); ?>
					<?php $form->error($model,'confirm_new_password'); ?>


	<div class="buttons">
		<?php echo CHtml::submitButton('Save',array( 'confirm'=>'Are you sure?',)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->