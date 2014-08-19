<?php
/* @var $this AssessmentController */
/* @var $model Assessment */

$this->breadcrumbs=array(
	'Assessments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Assessment', 'url'=>array('index')),
	array('label'=>'Create Assessment', 'url'=>array('create')),
	array('label'=>'View Assessment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Assessment', 'url'=>array('admin')),
);
?>

<h1>Update Assessment <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>