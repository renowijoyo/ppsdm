<?php
/* @var $this UserController */
/* @var $model User */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#education-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


$institution_id = '2';
			$reference_model = new Reference;
			$criteria = new CDbCriteria;
					$select = array('');
?>

<h1>Filter by school</h1>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="">
<?php $this->renderPartial('_searchadmin',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'education-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		
		array(
		'name'=>'profile_id',
		'value'=> function($model){
		//$profile_model = Profile::model()->loadProfile($model->institution_id);
		
		$criteria=new CDbCriteria;
		$criteria->select='*';  // only select the 'title' column
		$criteria->condition='id=:postID';
		$criteria->params=array(':postID'=>$model->profile_id);
		$profile_model = Profile::model()->find($criteria);
		$user_model = User::model()->findByPk($profile_model->user_id);
		//$user_model = User::controller()->loadModel($profile_model->user_id);
		return $user_model->username;},
		),
		
		array(
		'name'=>'profile_id',
		'header'=>'Nama',
		'value'=> function($model){	
		//$profile_model = Profile::model()->loadProfile($model->institution_id);
		
		$criteria=new CDbCriteria;
		$criteria->select='*';  // only select the 'title' column
		$criteria->condition='id=:postID';
		$criteria->params=array(':postID'=>$model->profile_id);
		$profile_model = Profile::model()->find($criteria);
		return $profile_model->first_name . ' ' . $profile_model->last_name;},
		),
		
		
							array(
		'name'=>'institution_id',
		'header'=>'Nama institusi',
		'value'=> function($model){
		$institution_model = Institution::model()->getInstitutionModel($model->institution_id);
		return $institution_model->info;},
		),
		'attribute_1',

array(
		'name'=>'start_year',
		'header'=>'Mulai',
		//'value'=> function($model){
		//$institution_model = Institution::model()->getInstitutionModel($model2->institution_id);
		//return $model->grade;},
						'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	

		),
array(
		'name'=>'graduate_year',
		'header'=>'Lulus',
		//'value'=> function($model){
		//$institution_model = Institution::model()->getInstitutionModel($model2->institution_id);
		//return $model->grade;},
						'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	

		),
		
		array(
		'name'=>'grade',
		'value'=> function($model){
		//$institution_model = Institution::model()->getInstitutionModel($model2->institution_id);
		return $model->grade;},
						'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	

		),


	),
)); 

?>
