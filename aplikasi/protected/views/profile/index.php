<?php
/* @var $this ProfileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Profiles',
);

$this->menu=array(
	//array('label'=>'Create Profile', 'url'=>array('create')),
	//array('label'=>'Manage Profile', 'url'=>array('admin')),
	array('label'=>'Data dasar', 'url'=>array('update')),
	array('label'=>'cv upload', 'url'=>array('cvupload')),
	array('label'=>'Pendidikan', 'url'=>array('education/index')),

);
?>

<h1>Profiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
