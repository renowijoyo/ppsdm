<?php
/* @var $this FamilyController */
/* @var $model Family */
/* @var $form CActiveForm */

	$reference_model = new Reference;
			$criteria = new CDbCriteria;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'family-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> <?php echo Yii::t('strings', 'required');?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		
		<?php echo $form->hiddenField($model,'profile_id'); ?>
		
	</div>

	<div class="row">
		<div class="label_name_column"><?php echo $form->labelEx($model,'name'); ?></div>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'relation_type_id'); ?></div>
		<?php 
			//echo $form->textField($model,'relation_type_id',array('size'=>60,'maxlength'=>255)); 
						$criteria->condition='category="relation_type"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'valueLocalized');
			
			//echo $form->dropDownList($model, 'relation_type_id',$list,array('prompt'=>'Pilih relasi',));
			
			echo CHtml::dropDownList('relation_type_id', $model->relation_type_id,$list ,array('empty' => Yii::t('strings', '(Select a relation type)')));
			echo $form->textField($model,'relation_type_id');
			?>
		
		<?php echo $form->error($model,'relation_type_id'); ?>

	</div>

		<div class="buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('strings', 'Save') : Yii::t('strings', 'Save')); ?>
			<?php echo CHtml::Button('Cancel',array('submit'=>array('profile/view')));?>
			</div>

<?php $this->endWidget(); ?>

</div><!-- form -->










<script type="text/javascript">
function reset()
{
	$('#Family_relation_type_id').hide();

	var exists = 0;
	$('#relation_type_id option').each(function() {
	  if (this.value == $('#Family_relation_type_id').val()) {
		exists = 1;
	  }
	});

	if (exists) //check if value is not in dropdown list
	{
	$('#relation_type_id').val($('#Family_relation_type_id').val());
	} else { //if value is IN dropdown list
		$('#relation_type_id').val("other");
		$("#Family_relation_type_id").show();
	}
}

$( document ).ready(function(){
reset();




		$('#relation_type_id').change(function(){
					if ($('#relation_type_id option:selected').val() == "other"){
				
						$("#Family_relation_type_id").show();
						$('#Family_relation_type_id').val('');
						
						} else {
						var value = $('#relation_type_id option:selected').val();
						$('#Family_relation_type_id').val(value);
						$("#Family_relation_type_id").hide();

						}
						
						});

});

</script>