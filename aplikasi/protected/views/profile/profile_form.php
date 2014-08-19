<?php
/* @var $this ProfileController */
/* @var $model Profile */
/* @var $form CActiveForm */

			$reference_model = new Reference;
			$criteria = new CDbCriteria;
					$select = array('');
			
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php 
		echo $form->hiddenField($model,'user_id');

		?>
	</div>
	


	<div class="">
		<div class="label_name_column"><?php echo $form->labelEx($model,'first_name'); ?></div>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="">
		<div class="label_name_column"><?php echo $form->labelEx($model,'last_name'); ?></div>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php $form->error($model,'last_name'); ?>
	</div>

	<div class="">
		<div class="label_name_column"><?php echo $form->labelEx($model,'date_of_birth'); ?></div>
		<?php 

$this->widget(
    'bootstrap.widgets.TbDatePicker',
    array(
        'model' => $model,
        'attribute' => 'date_of_birth',
				'options'=> array(
		    'format' => 'dd/mm/yyyy',
			   //'viewformat' => 'dd/mm/yyyy',
			),
        'htmlOptions' => array(
            'placeholder' =>'DD/MM/YYYY',
        ),

    )
);


		?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>

	<div class="input_form_row">
		<div class="label_name_column"><?php echo $form->labelEx($model,'place_of_birth'); ?></div>
	<div class="form_input_column">
		<?php
							$criteria->condition='category="city"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			echo CHtml::dropDownList('place_of_birth', $model->place_of_birth,$list ,array('empty' =>  Yii::t('strings', '(Select a value)')));
			?>
			
				<?php 
				echo $form->textField($model,'place_of_birth'); 
				?>
			</div>

			
		<?php $form->error($model,'place_of_birth'); ?>
				
	</div>

	<div class="input_form_row">

		<div class="label_name_column"><?php echo $form->labelEx($model,'gender_id'); ?></div>
		<?php //echo $form->textField($model,'gender_id',array('size'=>60,'maxlength'=>255)); ?>
		<div class="form_input_column">
		<?php	
			$criteria->condition='category="gender"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			echo $form->dropDownList($model,'gender_id', $list ,array('empty' =>  Yii::t('strings', '(Select a gender)')));
		?>
		</div>
		<?php $form->error($model,'gender_id'); ?>
	</div>

	<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'religion_id'); ?></div>
	<div class="form_input_column">
<?php
							$criteria->condition='category="religion"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($model, 'religion_id', $list ,array('empty' => '(Select a value)'));
				echo CHtml::dropDownList('religion_id', $model->religion_id,$list ,array('empty' => Yii::t('strings', '(Select a religion)')));
				echo $form->textField($model,'religion_id');
			?>
			</div>
		<?php $form->error($model,'religion_id'); ?>
	</div>

	<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'nationality_id'); ?></div>
	<div class="form_input_column">
		<?php
			$criteria->condition='category="nationality"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
	//		echo $form->dropDownList($model,'nationality_id', $list ,array('empty' => '(Select a nationality)'));
		
		//		echo $form->textField($model,'nationality_id',array('size'=>60,'maxlength'=>255)); 
		
			echo CHtml::dropDownList('nationality_id', $model->nationality_id,$list ,array('empty' =>  Yii::t('strings', '(Select a nationality)')));
			echo $form->textField($model,'nationality_id'); 
		?></div>
		<?php $form->error($model,'nationality_id'); ?>
	</div>

	<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'ethnicity_id'); ?></div>
	<div class="form_input_column">
		<?php 
		
					$criteria->condition='category="ethnicity"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($model,'ethnicity_id', $list ,array('empty' => '(Select a value)'));
			echo CHtml::dropDownList('ethnicity_id', $model->ethnicity_id,$list ,array('empty' => Yii::t('strings', '(Select a value)')));
			echo $form->textField($model,'ethnicity_id'); 
		
		?>
		
		</div>
		<?php $form->error($model,'ethnicity_id'); ?>
	</div>

	<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'marriage_status_id'); ?></div>
	<div class="form_input_column">
		<?php 
							$criteria->condition='category="marriage_status"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($model,'marriage_status_id',  $list ,array('empty' => '(Select a value)'));
				echo CHtml::dropDownList('marriage_status_id', $model->marriage_status_id,$list ,array('empty' => Yii::t('strings', '(Select a status)')));
				echo $form->textField($model,'marriage_status_id');

		?>
		</div>
		<?php $form->error($model,'marriage_status_id'); ?>
	</div>

	<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($model,'number_of_children'); ?></div>
	<div class="form_input_column">
		<?php echo $form->textField($model,'number_of_children'); ?></div>
		<?php $form->error($model,'number_of_children'); ?>
	</div>
	
	
	
	
		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($contact_model,'primary_no'); ?></div>
	<div class="form_input_column">
	
	
				<?php 
				
				
				$criteria->condition='category="contact_type"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			echo $form->dropDownList($contact_model,'primary_type_id', $list ,array('empty' => Yii::t('strings', '(Select a type)')));

				echo $form->textField($contact_model,'primary_no');
				?>
				</div>
		<?php $form->error($contact_model,'primary_no'); ?>
	</div>


	
		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($contact_model,'secondary_no'); ?></div>
	<div class="form_input_column">

				<?php 
				
								$criteria->condition='category="contact_type"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			echo $form->dropDownList($contact_model,'secondary_type_id', $list 	,array('empty' => Yii::t('strings', '(Select a type)')));
				echo $form->textField($contact_model,'secondary_no'); 
				?>
				</div>
		<?php $form->error($contact_model,'secondary_no'); ?>
	</div>


		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($address_model,'country_id'); ?></div>
	<div class="form_input_column">

		<?php 
				
			$criteria->condition='category="country"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($address_model,'secondary_type_id', $list 	,array('empty' => '(Select a country)'));
			echo CHtml::dropDownList('country_id', $address_model->country_id,$list ,array('empty' => Yii::t('strings', '(Select a country)')));
				echo $form->textField($address_model,'country_id'); 
				?>
				</div>
		<?php $form->error($address_model,'country_id'); ?>
	</div>

		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($address_model,'province_id'); ?></div>
	<div class="form_input_column">

		<?php 
				
			$criteria->condition='category="province"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($address_model,'secondary_type_id', $list 	,array('empty' => '(Select a country)'));
			echo CHtml::dropDownList('province_id', $address_model->province_id,$list ,array('empty' => Yii::t('strings', '(Select a province)')));
				echo $form->textField($address_model,'province_id'); 
				?>
				</div>
		<?php $form->error($address_model,'province_id'); ?>
	</div>
	
		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($address_model,'city_id'); ?></div>
	<div class="form_input_column">

		<?php 
				
			$criteria->condition='category="city"';
			$reference_model = Reference::model()->findAll($criteria);
			$list = CHtml::listData($reference_model, 'reference_key', 'reference_value');
			//echo $form->dropDownList($address_model,'secondary_type_id', $list 	,array('empty' => '(Select a country)'));
			echo CHtml::dropDownList('city_id', $address_model->province_id,$list ,array('empty' => Yii::t('strings', '(Select a city)')));
				echo $form->textField($address_model,'city_id'); 
				?>
				</div>
		<?php $form->error($address_model,'city_id'); ?>
	</div>
	
		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($address_model,'postal_code'); ?></div>
	<div class="form_input_column">

		<?php 

				echo $form->textField($address_model,'postal_code'); 
				?>
				</div>
		<?php $form->error($address_model,'postal_code'); ?>
	</div>
	
		<div class="input_form_row">
	<div class="label_name_column">	<?php echo $form->labelEx($address_model,'street_address'); ?></div>
	<div class="form_input_column">

		<?php 

				//echo $form->textArea($address_model,'street_address',array('maxlength' => 300, 'rows' => 6, 'cols' => 50)); 
					echo $form->textField($address_model,'street_address'); 
				?>
				</div>
		<?php $form->error($address_model,'street_address'); ?>
	</div>

		
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'confirm'=>'Are you sure?',)); ?>
		<?php echo CHtml::submitButton('Cancel', array('id' => 'reject')); ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



























<script type="text/javascript">

function reset()
{

$("#Profile_place_of_birth").hide();
$("#Profile_ethnicity_id").hide();
$("#Profile_religion_id").hide();
$("#Profile_nationality_id").hide();
$("#Profile_marriage_status_id").hide();
$("#ProfileAddress_country_id").hide();
$("#ProfileAddress_province_id").hide();
$("#ProfileAddress_city_id").hide();

var thevalue = $('#Profile_place_of_birth').val();
var exists = 0 != $('#place_of_birth option[value="'+thevalue+'"]').length;

var ethnicity_value = $('#Profile_ethnicity_id').val();
var ethnicity_exists = 0 != $('#ethnicity_id option[value="'+ethnicity_value+'"]').length;

var religion_value = $('#Profile_religion_id').val();
var religion_exists = 0 != $('#religion_id option[value="'+religion_value+'"]').length;

var nationality_value = $('#Profile_nationality_id').val();
var nationality_exists = 0 != $('#nationality_id option[value="'+nationality_value+'"]').length;

var marriage_value = $('#Profile_marriage_status_id').val();
var marriage_exists = 0 != $('#marriage_status_id option[value="'+marriage_value+'"]').length;

var country_value = $('#ProfileAddress_country_id').val();
var country_exists = 0 != $('#country_id option[value="'+country_value+'"]').length;

var province_value = $('#ProfileAddress_province_id').val();
var province_exists = 0 != $('#province_id option[value="'+province_value+'"]').length;

var city_value = $('#ProfileAddress_city_id').val();
var city_exists = 0 != $('#city_id option[value="'+city_value+'"]').length;
		
	if (!exists){
	$("#Profile_place_of_birth").show();
	$("#place_of_birth").val("other");
//	$("#place_of_birth").select2({ width: 'resolve',placeholder: 'place of birth'}).select2("val", "lain-lain");

	}
	
	if (!ethnicity_exists){
		$("#Profile_ethnicity_id").show();
		$("#ethnicity_id").val("other");
	} 
	if (!religion_exists){
		$("#Profile_religion_id").show();
		$("#religion_id").val("other");
	}
	if (!nationality_exists){
		$("#Profile_nationality_id").show();
		$("#nationality_id").val("other");
	}
	if (!marriage_exists){
		$("#Profile_marriage_status_id").show();
		$("#marriage_status_id").val("other");
	}
	if (!country_exists){
		$("#ProfileAddress_country_id").show();
		$("#ProfileAddress_country_id").prop("readonly",false);
		$("#country_id").val("other");
		//alert(country_value);
	}
	if (!province_exists){
		$("#ProfileAddress_province_id").show();
		$("#ProfileAddress_province_id").prop("readonly",false);
		$("#province_id").val("other");
	}
	if (!city_exists){
		$("#ProfileAddress_city_id").show();
		$("#ProfileAddress_city_id").prop("readonly",false);
		
		$("#city_id").val("other");
	}

}

		
		$( document ).ready(function(){

		
		
		
		
		
			
			reset();
			
			$('#place_of_birth').change(function(){
					if ($('#place_of_birth option:selected').val() == "other"){
						$("#Profile_place_of_birth").show();
						$('#Profile_place_of_birth').val('');
						
						} else {
						var value = $('#place_of_birth option:selected').val();
						$('#Profile_place_of_birth').val(value);
						$("#Profile_place_of_birth").hide();
							//reset();
						}
			});
			

			
		$('#ethnicity_id').change(function(){
					if ($('#ethnicity_id option:selected').val() == "other"){
						$("#Profile_ethnicity_id").show();
						$('#Profile_ethnicity_id').val('');
						
						} else {
						var value = $('#ethnicity_id option:selected').val();
						$('#Profile_ethnicity_id').val(value);
						$("#Profile_ethnicity_id").hide();
						}
		});
		
		$('#nationality_id').change(function(){
					if ($('#nationality_id option:selected').val() == "other"){
						$("#Profile_nationality_id").show();
						$('#Profile_nationality_id').val('');
						
						} else {
						var value = $('#nationality_id option:selected').val();
						$('#Profile_nationality_id').val(value);
						$("#Profile_nationality_id").hide();
						}
		});

		$('#religion_id').change(function(){
					if ($('#religion_id option:selected').val() == "other"){
						$("#Profile_religion_id").show();
						$('#Profile_religion_id').val('');
						
						} else {
						var value = $('#religion_id option:selected').val();
						$('#Profile_religion_id').val(value);
						$("#Profile_religion_id").hide();
						}
		});
		
		$('#marriage_status_id').change(function(){
					if ($('#marriage_status_id option:selected').val() == "other"){
						$("#Profile_marriage_status_id").show();
						$('#Profile_marriage_status_id').val('');
						
						} else {
						var value = $('#marriage_status_id option:selected').val();
						$('#Profile_marriage_status_id').val(value);
						$("#Profile_marriage_status_id").hide();
						}
		});
		
		$('#country_id').change(function(){
					if ($('#country_id option:selected').val() == "other"){
						$("#ProfileAddress_country_id").show();
						$('#ProfileAddress_country_id').val('');
						
						} else {
						var value = $('#country_id option:selected').val();
						$('#ProfileAddress_country_id').val(value);
						$("#ProfileAddress_country_id").hide();
						}
		});
		
		$('#province_id').change(function(){
					if ($('#province_id option:selected').val() == "other"){
						$("#ProfileAddress_province_id").show();
						$('#ProfileAddress_province_id').val('');
						
						} else {
						var value = $('#province_id option:selected').val();
						$('#ProfileAddress_province_id').val(value);
						$("#ProfileAddress_province_id").hide();
						}
		});

		$('#city_id').change(function(){
					if ($('#city_id option:selected').val() == "other"){
						$("#ProfileAddress_city_id").show();
						$('#ProfileAddress_city_id').val('');
						
						} else {
						var value = $('#city_id option:selected').val();
						$('#ProfileAddress_city_id').val(value);
						$("#ProfileAddress_city_id").hide();
						}
		});
		
		});



</script>



