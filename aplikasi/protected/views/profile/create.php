<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs=array(
	'Profiles'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Profile', 'url'=>array('index')),
	//array('label'=>'Manage Profile', 'url'=>array('admin')),
	array('label'=>'Data dasar', 'url'=>array('update')),
	array('label'=>'cv upload', 'url'=>array('cvupload')),
	array('label'=>'Pendidikan', 'url'=>array('education/index')),

);
?>


<?php 

 $this->renderPartial('profile_form', array('model'=>$model)); 
 
 ?>