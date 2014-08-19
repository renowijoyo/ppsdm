<?php
/* @var $this WorkhistoryController */
/* @var $model Workhistory */

$this->breadcrumbs=array(
	'Workhistories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Workhistory', 'url'=>array('index')),
	array('label'=>'Create Workhistory', 'url'=>array('create')),
	array('label'=>'Update Workhistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Workhistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Workhistory', 'url'=>array('admin')),
);
?>

<h1>View Workhistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'profile_id',
		'employer',
		'start_date',
		'finish_date',
		'description',
	),
)); ?>
