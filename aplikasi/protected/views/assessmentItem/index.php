<?php
/* @var $this AssessmentItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Assessment Items',
);

$this->menu=array(
	array('label'=>'Create AssessmentItem', 'url'=>array('create')),
	array('label'=>'Manage AssessmentItem', 'url'=>array('admin')),
);
?>

<h1>Assessment Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
