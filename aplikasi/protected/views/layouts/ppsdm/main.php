<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />



	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); ?>
</head>



<body>

<div class="" id="page">



	<div id="mainmenu">

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'brandLabel' => 'Welcome ' . Yii::app()->user->name,
    'display' => null, // default is static to top
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbNav',
            'items' => array(


				
				array('label' => 'Register', 'url' => '#'),
								array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)

            ),
        ),
    ),
)); ?>

	</div><!-- mainmenu -->

	<?php echo $content; ?>

	
	</div><!-- page -->


</body>
</html>