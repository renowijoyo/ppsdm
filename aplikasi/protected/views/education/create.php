<?php
/* @var $this EducationController */
/* @var $model Education */

$this->breadcrumbs=array(
	'Educations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Education', 'url'=>array('index')),
	array('label'=>'Manage Education', 'url'=>array('admin')),
);
?>

<h2><?php echo Yii::t('strings', '+ Add Education'); ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>