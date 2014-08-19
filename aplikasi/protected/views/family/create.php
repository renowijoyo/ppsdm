<?php
/* @var $this FamilyController */
/* @var $model Family */

$this->breadcrumbs=array(
	'Families'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Family', 'url'=>array('index')),
	array('label'=>'Manage Family', 'url'=>array('admin')),
);
?>

<h1>Tambah data keluarga</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>