<?php
/* @var $this FamilyController */
/* @var $model Family */

$this->breadcrumbs=array(
	'Families'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Family', 'url'=>array('index')),
	array('label'=>'Create Family', 'url'=>array('create')),
	array('label'=>'View Family', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Family', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('strings', 'Update Family'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>