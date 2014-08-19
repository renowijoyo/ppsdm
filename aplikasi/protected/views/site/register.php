<?php

?>

<h1><?php echo Yii::t('strings', 'Register'); ?></h1>

<p><?php echo Yii::t('strings', 'Please register with your email'); ?></p>

<div class="form" id="register">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



	<div class="">

		<div class="input_column"><?php echo $form->textField($model,'email', array(
			
					'placeholder'=>Yii::t('strings','Your Email'),
			)); ?></div>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="" id="password_field">

		<div class="input_column"><?php echo $form->textField($model,'password', array(
			
					'placeholder'=>Yii::t('strings','Your Password'),
			)); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>

	</div>


	<div class="buttons" id="submit_button_2">
		<?php echo CHtml::submitButton(Yii::t('strings', 'Register')); ?>
	</div>




<?php $this->endWidget(); ?>
</div>

<div id="spinner">
</div>


<?php  
//  $baseUrl = Yii::app()->baseUrl; 
 // $cs = Yii::app()->getClientScript();
  //$cs->registerScriptFile($baseUrl.'/js/spin.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/spin.js');

?>




<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/spin.js"></script>

<script type="text/javascript">
var opts = {
  lines: 13, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
};
var target = document.getElementById('spinner');
var spinner = new Spinner(opts).stop(target);


$("form").submit(function() {
//alert("subimita");
spinner.spin(target);
});

$(document).ready(
function() {
$("#password_field").show();
$("#submit_button_2").show();

}
);



</script>
