<?php /* @var $this Controller */ ?>
<?php Yii::app()->bootstrap->register(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
	<?php
	
		
	$profile_id = ExtendProfileController::loadProfile(Yii::app()->user->id);
	if ($profile_id !='')
	{
		//echo $profile_id;
		$update_or_create = array('profile/view');
		}
		else {
		$update_or_create = array('profile/create');
		//echo 'fasle';
	}
	
	
	?>
	
	
	
	
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
			array('label'=>'Home', 'url'=>array('/site/index')),
	

	

						array('label'=>'Profile', 'url'=>$update_or_create),
					//	array('label'=>'Upload CV', 'url'=>array('profile/cvupload','id'=>Yii::app()->user->id)),
						array('label'=>'Job Applications', 'url'=>array('application/index')),
						
						

	

								array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'ONET Test', 'url'=>array('application/page?view=2.2')),
						
				//http://127.0.0.1/ppsdm_portal/index.php/application/page?view=2.2
			),
		)); ?>
	</div><!-- mainmenu -->





	<?php 
	echo $content; 
	//echo 'reno';
	?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> PPSDM.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/test.js"></script>
</body>
</html>
