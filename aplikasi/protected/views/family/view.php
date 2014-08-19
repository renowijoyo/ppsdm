<?php
/* @var $this FamilyController */
/* @var $model Family */

$this->breadcrumbs=array(
	'Families'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Family', 'url'=>array('index')),
	array('label'=>'Create Family', 'url'=>array('create')),
	array('label'=>'Update Family', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Family', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Family', 'url'=>array('admin')),
);
?>

<h1>View Family #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'profile_id',
		'name',
		'relation_type_id',
	),
)); ?>
