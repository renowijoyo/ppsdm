<?php
/* @var $this AssessmentItemController */
/* @var $model AssessmentItem */

$this->breadcrumbs=array(
	'Assessment Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AssessmentItem', 'url'=>array('index')),
	array('label'=>'Create AssessmentItem', 'url'=>array('create')),
	array('label'=>'Update AssessmentItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssessmentItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssessmentItem', 'url'=>array('admin')),
);
?>

<h1>Halaman info untuk asesmen : <?php echo $model->name;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
		'type',
		//'url',
		'owner',
	//	'created',
		'status',
	),
)); ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assessment-item-form',
	'action'=>Yii::app()->createUrl('assessmentItem/start'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<input type="hidden" name="user" value="<?php echo Yii::app()->user->name;?>">
<input type="hidden" name="url" value="<?php echo $model->url;?>">
<input type="hidden" name="item" value="<?php echo $model->id;?>">
<?php

//echo "<a href=".$model->url."?user=".Yii::app()->user->name."><button>Take this test</button></a><br/>";
?>


	<div class="buttons">
		<?php echo CHtml::submitButton('Mulai asesmen', array('confirm'=>'Yakin? Press OK to continue.')); ?>
	</div>
<?php $this->endWidget(); ?>