<?php
/* @var $this WorkhistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Workhistories',
);

$this->menu=array(
	array('label'=>'Create Workhistory', 'url'=>array('create')),
	array('label'=>'Manage Workhistory', 'url'=>array('admin')),
);
?>

<h1>Workhistories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
