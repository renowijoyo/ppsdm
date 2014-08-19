<h1>TEST for Job: <?php echo $job_id = $_GET['view']; ?> </h1>
<br/>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'application-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action' => array( '/application/page', 'view'=>$job_id.'-process' )
)); ?>

1. siapakah presiden kita?<input name="ans1" type="text"></input>
<br/>
2. monas terletak di?<select name="ans2">
  <option value="jakarta">Jakarta</option>
  <option value="bandung">Bandung</option>

</select>
<br/>
	<div class="row buttons">
		<?php echo CHtml::submitButton("submit"); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->