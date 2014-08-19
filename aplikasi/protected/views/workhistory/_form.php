<?php
/* @var $this WorkhistoryController */
/* @var $model Workhistory */
/* @var $form CActiveForm */

	$reference_model = new Reference;
			$criteria = new CDbCriteria;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workhistory-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> <?php echo Yii::t('strings', 'required');?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">

		<?php echo $form->hiddenField($model,'profile_id'); ?>

	</div>

	<div class="">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'employer'); ?></div>
		<?php echo $form->textField($model,'employer',array('size'=>60,'maxlength'=>255)); ?>
		<?php $form->error($model,'employer'); ?>
	</div>
	
	
	
	
	
		<div class="">

		<div class="label_name_column"><?php echo $form->labelEx($model,'industry_id'); ?></div>
		<?php //echo $form->textField($model,'gender_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php	
			$criteria->condition='category="industry"';
			$reference_model = Reference::model()->findAll($criteria);
			// 	$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			$list = CHtml::listData($reference_model, 'reference_key', 'valueLocalized');
			//echo $form->dropDownList($model,'industry_id', $list ,array('empty' => Yii::t('strings', '(Select an industry)')));
			echo CHtml::dropDownList('industry_id', $model->industry_id,$list ,array('empty' => Yii::t('strings', '(Select an industry)')));
			echo $form->textField($model,'industry_id');
		?>
		<?php $form->error($model,'industry_id'); ?>
	</div>
	
	
	
	
	
		<div class="">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'position'); ?></div>
		<?php echo $form->textField($model,'position'); ?>
		<?php $form->error($model,'position'); ?>
	</div>

	<div class="">
		<div class="label_name_column"><?php echo $form->labelEx($model,'start_date'); ?></div>
		<?php 

$this->widget(
    'bootstrap.widgets.TbDatePicker',
    array(
		
        'model' => $model,
        'attribute' => 'start_date',
		'options'=> array(
		    'format' => 'dd/mm/yyyy',
			),
        'htmlOptions' => array(
            'placeholder' =>'DD/MM/YYYY',
        ),
    )
);
?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'finish_date'); ?></div>
				<?php 


$this->widget(
    'bootstrap.widgets.TbDatePicker',
    array(
		
        'model' => $model,
        'attribute' => 'finish_date',
		'options'=> array(
		    'format' => 'dd/mm/yyyy',
			),
        'htmlOptions' => array(
            'placeholder' =>'DD/MM/YYYY',
        ),
    )
);




?>
		<?php echo $form->error($model,'finish_date'); ?>
	</div>

	<div class="">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'description'); ?></div>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php $form->error($model,'description'); ?>
	</div>

	<div class=" buttons">

		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('strings', 'Save') : Yii::t('strings', 'Save')); ?>
		<?php echo CHtml::Button('Cancel',array('submit'=>array('profile/view')));?>
	</div>
	
	

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
function reset()
{
$('#Workhistory_industry_id').hide();

	var exists = 0;
	$('#industry_id option').each(function() {
	  if (this.value == $('#Workhistory_industry_id').val()) {
		exists = 1;
	  }
	});

	if (exists) //check if value is not in dropdown list
	{
	$('#industry_id').val($('#Workhistory_industry_id').val());
	} else { //if value is IN dropdown list
		$('#industry_id').val("other");
		$("#Workhistory_industry_id").show();
	}
	
}

$( document ).ready(function(){
reset();




		$('#industry_id').change(function(){
					if ($('#industry_id option:selected').val() == "other"){
				
						$("#Workhistory_industry_id").show();
						$('#Workhistory_industry_id').val('');
						
						} else {
						var value = $('#industry_id option:selected').val();
						$('#Workhistory_industry_id').val(value);
						$("#Workhistory_industry_id").hide();

						}
						
						});













});

</script>