<?php
/* @var $this AssessmentController */
/* @var $model Assessment */

$this->breadcrumbs=array(
	'Assessments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Assessment', 'url'=>array('index')),
	array('label'=>'Create Assessment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#assessment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Assessments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assessment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'profile_id',
		'tao_subject',
		'assessment_item_id',
		'tao_test',
		'tao_test_label',
		/*
		'tao_delivery_label',
		'tao_delivery_result',
		'tao_delivery_status',
		'start_time',
		'finish_time',
		'note',
		'result_url',
		'download_url',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
