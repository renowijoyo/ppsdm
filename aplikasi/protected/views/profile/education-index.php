<?php
/* @var $this EducationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Educations',
);


?>
<?php

$this->menu=array(


	array('label'=>'Data personal', 'url'=>array('profile/update')),
	array('label'=>'cv upload', 'url'=>array('profile/cvupload')),
	array('label'=>'Pendidikan', 'url'=>array('profile/education', )),
);
?>
<h1>Pendidikan</h1>

<?php echo CHtml::link('Add new education ',array('education/create')); ?>


<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'education-grid',
	'dataProvider'=>$dataProvider,
	
	
	
		'columns'=>array(
	
	
	
			array(
'name'=>'academic_level_id',
'value'=>function($model2){
$academic_level_text = Reference::model()->getAcademicLevelText($model2->institution_id);
return $academic_level_text;},

),
		
		

		array(
'name'=>'institution_id',
'value'=>function($model2){
$institution_text = '';
$institution_text = Institution::model()->getInstitutionText($model2->institution_id);
return $institution_text;},

),
		
		
/*
		
			array(
'name'=>'study_id',
'value'=>function($model2){
$academic_level_text = Reference::model()->getStudyText($model2->study_id);
return $academic_level_text;},

),

*/
		'start_year',
		
		'graduate_year',
				array(
			'class'=>'CButtonColumn',
			  'template'=>'{delete}{update}',
			   'buttons'=>array(
			   
               'delete'=>array(
                         'url'=>'$this->grid->controller->createUrl("/education/delete", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                         ),	
			   
               'update'=>array(
                         'url'=>'$this->grid->controller->createUrl("/education/update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                         'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                         ),
						 ),
		),
		

	),
	
	
	
	
	
	

)); 

?>

<?php 
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_education_view',
)); 
*/
?>
