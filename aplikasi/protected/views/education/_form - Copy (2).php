<?php
/* @var $this EducationController */
/* @var $model Education */
/* @var $form CActiveForm */


			$reference_model = new Reference;
			$criteria = new CDbCriteria;
					$select = array('');


//Yii::app()->clientScript->registerCoreScript('jQuery');
					
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


		<?php echo $form->hiddenField($model,'profile_id'); ?>
		<?php 
		echo $form->hiddenField($model,'institution_id');
		?>
		
		

			<div class=""  >
			<div class="label_name_column"><label for="academic_level_id">Tingkat akademis</label></div>
		<div class="education_input" id="academic_level_id">
		<?php	
		
			$criteria->condition='category="academic_level"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			
			echo $form->dropDownList($model, 'academic_level_id',$list,
			array('prompt'=>'Pilih tingkatan akademis',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxinstitution'), //url to call.
                                        'update'=>'#Education_institution_name',
                                    ))); 
										echo $form->error($model,'academic_level_id');
		?>
		
		</div>
	</div>
	
 <div class="" id="input_well">
	<div id="institution_name_input"  >
		<div class="label_name_column"><?php echo $form->labelEx($model,'institution_id'); ?></div>
			<div class="education_input" id="institution_name">
			<?php

			echo $form->dropDownList($model,'institution_name', array() ,
								array(
					'prompt'=>'Pilih institusi',
				                        'ajax'  => array(
                                        'type'  =>'POST',
                                        'url'   =>CController::createUrl('Ajaxattribute1'), //url to call.
                                       // 'data'  => array("listname" => 'js:jQuery(this).val()'),
                                        'update'=>'#Education_attribute_1',
                                    )));
			?>
				<?php echo $form->textField($model,'note'); ?>
			</div>
	</div>
	<div class=""  id="attribute_1_input">
					<div class="label_name_column">	<label for="attribute_1">Fakultas</label></div>
				<div class="education_input">
						<?php echo $form->dropDownList($model,'attribute_1',array(),
									array(
									'prompt'=>'Pilih Fakultas',
														'ajax'  => array(
														'type'  =>'POST',
														'url'   =>CController::createUrl('Ajaxattribute2'), //url to call.
														'empty'=>'Pilih Jenis',
													   // 'data'  => array("listname" => 'js:jQuery(this).val()'),
														'update'=>'#Education_attribute_2',
													)
								)
						
						); 
						//	echo $form->error($model,'institution_id');
						?>

					</div>
					

	</div>

		<div class="" id="attribute_2_input">
	
	
	
	
		<div class="label_name_column">	<label for="attribute_2">Jurusan</label></div>
		<div class="education_input" >
	
		
		<?php echo $form->dropDownList($model,'attribute_2', array(),
		

		
		
					array( 'prompt'=>'Pilih jurusan',
					

				)

		
		); 
		//	echo $form->error($model,'institution_id');
		?>

	</div>
	
	
	</div>

	</div>
	
	
	
	 <div class="" id="input_well_2">
	
	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'start_year'); ?></div>
		<div class="form_input_column"><?php echo $form->textField($model,'start_year'); ?></div>

	</div>

	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'graduate_year'); ?></div>
		<div class="form_input_column"><?php echo $form->textField($model,'graduate_year'); ?></div>
		
	</div>

	<div class="">
			<div class="label_name_column"><?php echo $form->labelEx($model,'grade'); ?></div>
		<div class="form_input_column"><?php echo $form->textField($model,'grade'); ?></div>
	
	</div>
<div style="margin-left:50%;">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Save'); ?>
	</div>


	
	
	
	
	

	</div>




<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">


function reset()
{

	$("#input_well").hide();
	$("#input_well_2").hide();
$("#education_submit").hide();


	$("#Education_institution_name select option").removeAttr("selected");
	$("#attribute_2_input select option").removeAttr("selected");
	$("#attribute_1_input select option").removeAttr("selected");

	$('#attribute_1_input').hide();
	$('#attribute_2_input').hide();
	$('#Education_note').hide();
	$('#Education_note').val('');

	
	$('#Education_start_year').val('');
	$('#Education_graduate_year').val('');
	$('#Education_grade').val('');
	
		$('#Education_institution_id').val('');
	
}

function resetInstitutionName()
{
	$("#input_well_2").hide();



	$("#attribute_2_input select option").removeAttr("selected");
	$("#attribute_1_input select option").removeAttr("selected");

	$('#attribute_1_input').hide();
	$('#attribute_2_input').hide();
	$('#Education_note').hide();
	$('#Education_note').val('');
}






$( document ).ready(function(){


		$("#Education_institution_name").select2();
		reset();

		$('#academic_level_id').change(function(){
			reset();
			$("#input_well").show();
		});


		$('#Education_institution_name').change(function(){
			resetInstitutionName();
			$("#input_well_2").show();
			$("#education_submit").show();

			if (($('#Education_institution_name option:selected').val() != '')   &&  ($('#academic_level_id option:selected').val() >= '4')){ 
						
						$('#attribute_1_input').show();
						$('#attribute_2_input').show();
					} else {
						$('#attribute_1_input').hide();
						$('#attribute_2_input').hide();
					}
					
				if (($('#Education_institution_name option:selected').val() == 'other'))
						{
						$('#Education_note').show();
						$('#attribute_1_input').hide();
						$('#attribute_2_input').hide();
						$("#attribute_2_input select option").removeAttr("selected");
				$("#attribute_1_input select option").removeAttr("selected");

						} else {
								$('#Education_note').hide();
								$('#Education_note').val('');
					}
		});

		
		/*
		$('#attribute_1_input').change(function(){

				if (    ($('#attribute_1_input option:selected').val() != '') &&  ($('#Education_institution_name option:selected').val() != '')   &&  ($('#academic_level_id option:selected').val() >= '4')           ){ //only when selection is University show attribute_1 and attribute_2
					
					$('#attribute_2_input').show();
				} else {
					$('#attribute_2_input').hide();
				}

		});
*/


		$('#education-form').submit(function(){
			/*alert("institusi : " + $("#Education_institution_name option:selected").val() + 
			" | attribute 1 : " + $("#attribute_1_input option:selected").val() + 
				" | ACADEMIC LEVEL: " + $("#academic_level_id option:selected").val() + 
			" | attribute 2 : " + $("#attribute_2_input option:selected").val() +
			" | NOTE : " + $("#Education_note").val() 
			);
		*/
		});




});


</script>