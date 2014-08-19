<?php
/* @var $this AssessmentItemController */
/* @var $model AssessmentItem */

$this->breadcrumbs=array(
	'Assessment Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssessmentItem', 'url'=>array('index')),
	array('label'=>'Manage AssessmentItem', 'url'=>array('admin')),
);
?>

<h1>Create AssessmentItem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>