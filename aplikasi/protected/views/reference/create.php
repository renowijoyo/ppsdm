<?php
/* @var $this ReferenceController */
/* @var $model Reference */

$this->breadcrumbs=array(
	'References'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Reference', 'url'=>array('index')),
	array('label'=>'Manage Reference', 'url'=>array('admin')),
);
?>

<h1>Create Reference</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>