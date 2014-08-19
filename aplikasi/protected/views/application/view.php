<?php
/* @var $this ApplicationController */
/* @var $model Application */
/*
$this->breadcrumbs=array(
	'Applications'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Application', 'url'=>array('index')),
	array('label'=>'Create Application', 'url'=>array('create')),
	array('label'=>'Update Application', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Application', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Application', 'url'=>array('admin')),
);
*/
?>

<?php
/*
echo $model->user_id;

	echo "=====|" . Yii::app()->user->name;
	echo "|user_id=" . Yii::app()->user->id;
	echo "|application_id=" . $model->id;
		echo "|application_owner=" . $model->user_id;
		
		
	*/	
		
		
		
		
		if ($model->job_id == 1) {
			echo '<img src="'. Yii::app()->baseUrl.'/images/pertamina_logo.jpg"><br/>';
		} else {
			echo '<img src="'. Yii::app()->baseUrl.'/images/lipi_logo.jpg"><br/>';
		}

	$profile_id = ExtendProfileController::loadProfile(Yii::app()->user->id);

	if ($profile_id !='')
	{
		//echo 'h';
		//echo $profile_id;
		$update_or_create = array('/application/page', 'view'=>($model->job_id .'.'. $model->job_id));
		echo CHtml::link('click here to proceed',$update_or_create);
		//
		}
		else {
		$update_or_create = array('profile/create','id'=>$profile_id);
		echo "you have not complete your regsitration data. ";
		echo CHtml::link('click here to complete registration',$update_or_create);
		echo '<br/>';
		}
?>


	
<?php 

/*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'job_id',
		'referencing_site',
		'status_id',
		'date_created',
	),
)); 
*/
?>
