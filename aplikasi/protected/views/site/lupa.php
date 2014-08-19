<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);


   foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	
	
?>

<h1><?php echo Yii::t('strings', 'Send Password To Email'); ?></h1>
<br/>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



	<div class="">

		<div class="input_column">	
		<?php echo CHtml::textField('username','',array(
		'placeholder'=>Yii::t('strings','Your Email'),
		
		)); ?></div>
	</div>




	
	<div class="buttons input_button_column">
		<?php echo CHtml::submitButton(Yii::t('strings', 'Send')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
