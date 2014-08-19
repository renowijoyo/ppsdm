<?php
/* @var $this AssessmentController */
/* @var $model Assessment */

$this->breadcrumbs=array(
	'Assessments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Assessment', 'url'=>array('index')),
	array('label'=>'Manage Assessment', 'url'=>array('admin')),
);
?>

<h1>Create Assessment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>