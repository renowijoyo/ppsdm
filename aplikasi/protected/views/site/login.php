<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div style="margin-top:90px;"></div>
<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/ppsdm.png'); ?>


<div style="margin-top:30px; font-size:1.3em;font-style:italic">Selamat datang di Aplikasi Online PPSDM</div>
<div style="font-size:1.3em;font-style:italic">Aplikasi ini dibuat untuk kemudahan Anda mendaftarkan aplikasi diri Anda dalam database PPSDM untuk tujuan rekruitmen maupun seleksi calon karyawan</div>
<br/>
<div class="well" style="background:#3e4095; color:white;">
<div><h2 style="margin-top:0px;">Petunjuk Umum</h2></div>
<div style="text-align:left;">
<ol>
<li>Silahkan lakukan registrasi terlebih dahulu sebelum Anda login</li>
<li>Setelah anda registrasi Anda akan menerima email berisi kode validasi dan link untuk memasukkan kode validasi tersebut, klik link tersebut, kemudian masukkan kode validasinya</li>
<li>Silahkan login dengan menggunakan email & password Anda</li>
<li>Isilah data diri Anda sebenarnyaa dan sesuai dengan form yang tersedia</li>
<li>Selamat mengerjakan</li>
<li>Terima kasih</li>
</ol>

</div>
</div>
<h1><?php echo Yii::t('strings', 'Login'); ?></h1>
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

		<div class="input_column">	<?php echo $form->textField($model,'username',array(
		'placeholder'=>Yii::t('strings','Your Email'),
		
		)); ?></div>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="">
	
			<div class="input_column"><?php echo $form->passwordField($model,'password', array(
			
					'placeholder'=>Yii::t('strings','Your Password'),
			)); ?></div>
		<?php echo $form->error($model,'password'); ?>

	</div>

	<!--div class="rememberMe">
		<div class="label_name_column"><?php echo $form->checkBox($model,'rememberMe'); ?></div>
			<div class="input_column"><span>
		<?php echo Yii::t('strings', 'remember me next time'); ?></span></div>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div-->
	
	<div class="buttons input_button_column">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<br/><br/>
<div class="input_column">Lupa kata sandi anda? <?php echo CHtml::link(Yii::t('strings', 'Click Here'),array('site/lupa'), array("style"=>"color: green;")); ?></div>
