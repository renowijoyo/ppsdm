<?php
/* @var $this AssessmentController */
/* @var $model Assessment */

$this->breadcrumbs=array(
	'Assessments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Assessment', 'url'=>array('index')),
	array('label'=>'Create Assessment', 'url'=>array('create')),
	array('label'=>'Update Assessment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Assessment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assessment', 'url'=>array('admin')),
);
?>

<h1>View Assessment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'profile_id',
		'tao_subject',
		'assessment_item_id',
		'tao_test',
		'tao_test_label',
		'tao_delivery_label',
		'tao_delivery_result',
		'tao_delivery_status',
		'start_time',
		'finish_time',
		'note',
		'result_url',
		'download_url',
	),
)); ?>
