<?php
/* @var $this WorkhistoryController */
/* @var $model Workhistory */

$this->breadcrumbs=array(
	'Workhistories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Workhistory', 'url'=>array('index')),
	array('label'=>'Create Workhistory', 'url'=>array('create')),
	array('label'=>'View Workhistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Workhistory', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('strings', 'Update Workhistory'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>