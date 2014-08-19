<?php
/* @var $this WorkhistoryController */
/* @var $model Workhistory */

$this->breadcrumbs=array(
	'Workhistories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Workhistory', 'url'=>array('index')),
	array('label'=>'Manage Workhistory', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('strings', 'Create Workhistory');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>