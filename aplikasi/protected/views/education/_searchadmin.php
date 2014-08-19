<?php
/* @var $this EducationController */
/* @var $model Education */
/* @var $form CActiveForm */

			$reference_model = new Reference;
			$criteria = new CDbCriteria;
					$select = array('');
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


			<div class=""><label for="academic_level_id">Tingkat akademis</label></div>
		<div class="education_input" id="academic_level_id">
		<?php	
		
			$criteria->condition='category="academic_level"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			
			echo $form->dropDownList($model, 'academic_level_id',$list,
			array(
			'prompt'=>'Pilih tingkatan akademis',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxinstitution'), //url to call.
                                        'update'=>'#Education_institution_id',
                                    ))); 
										echo $form->error($model,'academic_level_id');
		?>
		
		</div>
		
		


	<div class="">
		<?php 
		//echo $form->label($model,'profile_id');
		//echo $form->textField($model,'profile_id'); 
		?>
	</div>

	<div class="">


		
			<div class="select2_input" id="institution_name_input"  >
		<div class=""><?php echo $form->labelEx($model,'institution_id'); ?></div>
			<div class="education_input" id="institution_name">
			<?php
			echo $form->dropDownList($model, 'institution_id',array());
			?>
			</div>
	</div>
	</div>
	<div class="">
		<?php echo $form->label($model,'attribute_1'); ?>
		<?php echo $form->textField($model,'attribute_1'); ?>
	</div>
	<div class="">
		<?php echo $form->label($model,'start_year'); ?>
		<?php echo $form->textField($model,'start_year'); ?>
	</div>

	<div class="">
		<?php echo $form->label($model,'graduate_year'); ?>
		<?php echo $form->textField($model,'graduate_year'); ?>
	</div>

	<div class="">
		<?php echo $form->label($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->