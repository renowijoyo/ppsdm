<?php
/* @var $this EducationController */
/* @var $model Education */
/* @var $form CActiveForm */


			$reference_model = new Reference;
			$criteria = new CDbCriteria;
					$select = array('');
Yii::app()->clientScript->registerCoreScript('jQuery');
					
?>

<div class="form">




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'education-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php 
		//echo $form->textField($model,'profile_id');
		
		echo $form->hiddenField($model,'profile_id');
		?>
		<?php echo $form->error($model,'profile_id'); ?>
	</div>
	
		<div class="">
		<?php 
//echo $form->labelEx($model,'institution_id');
		
		echo $form->textField($model,'institution_id');
	//	echo $form->error($model,'institution_id')
		?>
	</div>
	
	<div class=""  >
			<div class="label_name_column"><label for="academic_level_id">Tingkat akademis</label></div>
		<div class="education_input" id="academic_level_id">
		<?php	
		
			$criteria->condition='category="academic_level"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo CHtml::dropDownList('academic_level_id', '',$list,
			echo $form->dropDownList($model, 'academic_level_id',$list,
			array('prompt'=>'Pilih tingkatan akademis',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxinstitution'), //url to call.
                                        'update'=>'#Education_institution_name',
                                    ))); 
										echo $form->error($model,'institution_id');
		?>
		
		</div>
	</div>
	
	

	<div class="education_input" id="institution_name_input">

			<div class="label_name_column"><label for="institution_name">Institusi</label></div>
		<?php 
		
		echo $form->dropDownList($model, 'institution_name', array(),
		
					array(
			//		'prompt'=>'Pilih institusi',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxattribute1'), //url to call.
                                       // 'data'  => array("listname" => 'js:jQuery(this).val()'),
                                        'update'=>'#Education_attribute_1',
                                    )
				)
		
		
		);
			
			/*
			
			
			
$this->widget(
    'bootstrap.widgets.TbTypeahead',
    array(
        'name' => 'Education_institution_name',
		//'model'     => $model,
        'options' => array(
		 'name' => 'Education_institution_name',
            'source' => $this->createUrl('education/autocompleteTest'),
			// 'source' => array('ha','la'),
            'items' => 4,
        ),
    )
);
			



			
			
			
			
			*/
			
			
			
			
			
			
			
			
			
			
			echo $form->error($model,'institution_id');
			?>
	</div>
	
	<div class="education_input" id="attribute_1_input">
		<label for="attribute_1">Fakultas</label>
		<?php echo $form->dropDownList($model,'attribute_1',array(),
		
					array(
				//	'prompt'=>'Pilih Fakultas',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxattribute2'), //url to call.
										'empty'=>'Pilih Jenis',
                                       // 'data'  => array("listname" => 'js:jQuery(this).val()'),
                                        'update'=>'#Education_attribute_2',
                                    )
				)
		
		); 
			echo $form->error($model,'institution_id');
		?>

	</div>
	
	<div class="education_input" id="attribute_2_input"">
		<label for="attribute_2">Jurusan</label>
		
		<?php echo $form->dropDownList($model,'attribute_2', array(),
		

		
		
					array( 'prompt'=>'Pilih jurusan',
					
				                  /*      'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxgetinstitutionid'), //url to call.
                                       // 'data'  => array("listname" => 'js:jQuery(this).val()'),
                                        'update'=>'#Education_institution_id',
                                    )
									*/
				)

		
		); 
			echo $form->error($model,'institution_id');
		?>

	</div>
	
<hr/><hr/>

	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'start_year'); ?></div>
		<?php echo $form->textField($model,'start_year'); ?>
		<?php echo $form->error($model,'start_year'); ?>
	</div>

	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'graduate_year'); ?></div>
		<?php echo $form->textField($model,'graduate_year'); ?>
		<?php echo $form->error($model,'graduate_year'); ?>
	</div>

	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'grade'); ?></div>
		<?php echo $form->textField($model,'grade'); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>
	



	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

$( document ).ready(function(){
$('#attribute_1_input').hide();
$('#attribute_2_input').hide();
$('#institution_name_input').hide();

// institusi hanya di show kalau academic_value 3 (SMU) keatas
// kalau academic_value == 4 tunjukkan attribute_1


$('#academic_level_id').change(function(){
	if ($('#academic_level_id option:selected').val() > '2')
	{
		$('#institution_name_input').show();
		if ($('#academic_level_id option:selected').val() == '4')
			{
			
				//$('#attribute_1_input').show();
				//$('#attribute_2_input').show();
			} else {
				$('#attribute_1_input').hide();
				$('#attribute_2_input').hide();
			}
	}
	else
	{
		$('#institution_name_input').hide();
		$('#attribute_1_input').hide();
		$('#attribute_2_input').hide();
	}
});

$('#institution_name_input').change(function(){
		if (($('#institution_name_input option:selected').val() != '')   &&  ($('#academic_level_id option:selected').val() == '4')           ){ //only when selection is University show attribute_1 and attribute_2
			
			$('#attribute_1_input').show();
		} else {
			$('#attribute_1_input').hide();
		}
});

$('#attribute_1_input').change(function(){


//	alert($("option:selected", this).val());
		if (    ($('#attribute_1_input option:selected').val() != '') &&  ($('#institution_name_input option:selected').val() != '')   &&  ($('#academic_level_id option:selected').val() == '4')           ){ //only when selection is University show attribute_1 and attribute_2
			
			$('#attribute_2_input').show();
		} else {
			$('#attribute_2_input').hide();
		}

});

$('#education-form').submit(function(){
	/*alert("institusi : " + $("#institution_name_input option:selected").val() + 
	" | attribute 1 : " + $("#attribute_1_input option:selected").val() + 
		" | ACADEMIC LEVEL: " + $("#academic_level_id option:selected").val() + 
	" | attribute 2 : " + $("#attribute_2_input option:selected").val() 
	);
	*/
	//$("#Education_institution_id").val('6');
	//alert('submitted form');
	
});

$('.education_input').change(function(){

	//	alert($("option:selected", this).val());
});


});


</script>