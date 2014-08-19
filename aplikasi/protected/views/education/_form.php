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

	<p class="note"><span class="required">*</span> <?php echo Yii::t('strings', 'required');?>.</p>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->hiddenField($model,'profile_id'); ?>
		<?php echo $form->hiddenField($model,'id'); ?>
		<?php 
		echo $form->hiddenField($model,'institution_name');
		?>
		
		

			<div class="education_form">
			<div class="label_name_column"><label for="academic_level_id"><?php echo Yii::t('strings', 'Academic Level');?></label></div>
		<div class="education_input" id="academic_level_id">
		<?php	
		
			$criteria->condition='category="academic_level"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key',function($list){return Reference::model()->getLocalized($list['reference_value']);});
			
			
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
	</div>
	
 <div class="" id="input_well">
	<div class="select2_input" id="institution_name_input"  >
		<div class="label_name_column"><?php echo $form->labelEx($model,'institution_id'); ?></div>
			<div class="education_input" id="institution_name">
			<?php
			echo $form->dropDownList($model, 'institution_id',array());
			?>
				<?php echo $form->textField($model,'attribute_2'); ?>
			</div>
	</div>
	<div class="select2_input"  id="attribute_1_input">
					<div class="label_name_column">	<label for="attribute_1">Jurusan</label></div>
				<div class="education_input">
						<?php 
						
						$criteria->condition='category="major"';
						$reference_model = Reference::model()->findAll($criteria);
						$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');

						echo CHtml::dropDownList('attribute_1', $model->attribute_1,$list ,array('empty' => '(Select a value)'));
						//echo $form->dropDownList($model, 'attribute_1',$list,
					//	array('prompt'=>'Pilih jurusan',));
						echo $form->textField($model,'attribute_1');

						?>

					</div>
					

	</div>


	</div>
	
	
	
	 <div class="" style="" id="input_well_2">
	
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
<?php echo CHtml::Button('Cancel',array('submit'=>array('profile/view')));?>
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


	$("#Education_institution_id select option").removeAttr("selected");
	$("#attribute_1_input select option").removeAttr("selected");

	$('#attribute_1_input').hide();

	$('#Education_attribute_2').hide();
	$('#Education_attribute_2').val('');
	
	$('#Education_attribute_1').hide();
	$('#Education_attribute_1').val('');

	
	$('#Education_start_year').val('');
	$('#Education_graduate_year').val('');
	$('#Education_grade').val('');
	
		//$('#Education_institution_id').val('');
		
		$("#Education_institution_id").prop("disabled",false);
$("#Education_attribute_2").prop("readonly",false);
$("#Education_attribute_1").prop("readonly",false);
$("#attribute_1").prop("disabled",false);

		
	
}

function preload()
{

	if ($('#Education_attribute_2').val().length > 0)
		{
	//alert($('#Education_attribute_2').val().length > 0);
			$('#Education_attribute_2').show();
	//		$('#Education_attribute_2').val('masak');
			$('#Education_institution_id').append('<option>other</option>');

		} else {
		//	alert('empty');
			//alert($('#Education_institution_name').val());
			$('#Education_attribute_2').hide();
			$('#Education_institution_id').append('<option>'+($('#Education_institution_name').val())+'</option>');
		}
	
	if ($("#attribute_1 option[value='"+$('#Education_attribute_1').val()+"']").length !== 0)
//var exists = $("#mySelect option[value='-1']").length !== 0
{
$('#Education_attribute_1').hide();
	
	} else {
			$('#attribute_1').val('other');
	}
				
		
}

function resetInstitutionName()
{
	$("#input_well_2").hide();



	$("#attribute_1_input select option").removeAttr("selected");

	$('#attribute_1_input').hide();

	$('#Education_attribute_2').hide();
	$('#Education_attribute_2').val('');
}






$( document ).ready(function(){

//$("#Education_institution_id").select2({ width: 'resolve',placeholder: 'Pilih institusi'});
//$("#attribute_1").select2({ width: 'resolve', placeholder: 'Pilih jurusan'});

//FIRST determine if there's an already existing value

if($('#Education_id').val() > 0)
{
//alert($('#Education_id').val()); //CREATE NEW
preload();
$("#Education_institution_id").prop("disabled",true);
$("#Education_attribute_2").prop("readonly",true);
$("#Education_attribute_1").prop("readonly",true);
$("#attribute_1").prop("disabled",true);

} else {
reset();
}



		$('#academic_level_id').change(function(){
			reset();
			$("#input_well").show();
		});


		$('#Education_institution_id').change(function(){
			resetInstitutionName();
			$("#input_well_2").show();
			$("#education_submit").show();
//alert ($('#Education_institution_id option:selected').text());
				/*if (($('#Education_institution_id option:selected').val() != '')   &&  ($('#academic_level_id option:selected').val() >= '4')){ 
						$('#attribute_1_input').show();
					} else {
						$('#attribute_1_input').hide();
					}
					*/
				//alert ($('#Education_institution_id option:selected').val());
				
					if (($('#Education_institution_id option:selected').text() == 'other') )
						{
						$('#Education_attribute_2').show(); //field untuk lain lain-lain
						//$('#attribute_1_input').show();	//field untuk jurusan
						$("#attribute_1_input select option").removeAttr("selected");
						} 
						
						jurusan_array = ['s1', 's2', 's3'];
					if (jurusan_array.indexOf($('#academic_level_id option:selected').val()) != -1)
					{
						$('#attribute_1_input').show();	//field untuk jurusan
					}
				/*if (($('#Education_institution_id option:selected').text() == 'other')  &&  ($('#academic_level_id option:selected').val() >= '4') )
						{
						$('#Education_attribute_2').show();
						$('#attribute_1_input').show();
						$("#attribute_1_input select option").removeAttr("selected");
						} 
					
					
				else if (($('#Education_institution_id option:selected').text() == 'other' )  &&  ($('#academic_level_id option:selected').val() < '4') )
						{
						
						$('#Education_attribute_2').show();
						$('#attribute_1_input').hide();

						$("#attribute_1_input select option").removeAttr("selected");

						} 
				else {
								$('#Education_attribute_2').hide();
								$('#Education_attribute_2').val('');
					}
					*/
					
					
		});

		
		
		$('#attribute_1').change(function(){
					if ($('#attribute_1 option:selected').val() == "other"){
						//alert('yuhuui');
						$("#Education_attribute_1").show();
						$('#Education_attribute_1').val('');
						
						} else {
						var value = $('#attribute_1 option:selected').val();
						$('#Education_attribute_1').val(value);
						$("#Education_attribute_1").hide();
							//reset();
						}

		});



});


</script>