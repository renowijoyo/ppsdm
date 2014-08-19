<?php
/* @var $this ReferenceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'References',
);

$this->menu=array(
	array('label'=>'Create Reference', 'url'=>array('create')),
	array('label'=>'Manage Reference', 'url'=>array('admin')),
);
?>

<h1>References</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
