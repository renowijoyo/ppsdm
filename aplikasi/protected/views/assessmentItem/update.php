<?php
/* @var $this AssessmentItemController */
/* @var $model AssessmentItem */

$this->breadcrumbs=array(
	'Assessment Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssessmentItem', 'url'=>array('index')),
	array('label'=>'Create AssessmentItem', 'url'=>array('create')),
	array('label'=>'View AssessmentItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssessmentItem', 'url'=>array('admin')),
);
?>

<h1>Update AssessmentItem <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>