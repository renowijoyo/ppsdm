<?php
/* @var $this AssessmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Assessments',
);

$this->menu=array(
	array('label'=>'Create Assessment', 'url'=>array('create')),
	array('label'=>'Manage Assessment', 'url'=>array('admin')),
);
?>






<?php 
$criteria=new CDbCriteria;
//.$criteria->select='title';  // only select the 'title' column
$criteria->condition='status=:status';
$criteria->params=array(':status'=>'active');

     //$assessment_item = assessmentItem::model()->find('owner=:status', array(':status'=>1));
	 $assessment_item = AssessmentItem::model()->findAll($criteria);
	 //$post=Post::model()->find('postID=:postID', array(':postID'=>10));
	 
	 $item_model=new AssessmentItem('search');
 
     // format models resulting using listData     
     $list = CHtml::listData($assessment_item, 
                'id', 'url');    
 
if(isset($_GET['error'])) {
							   			$this->widget('bootstrap.widgets.TbAlert', array(
									'block' => true,
									'fade' => true,
									'closeText' => false, // false equals no close link
									'events' => array(),
									'htmlOptions' => array(),
									'userComponentId' => 'user',
									'alerts' => array( // configurations per alert type
										$_GET['error'] => array('block' => false, 'closeText' => false),
									),
							));
							
							}
?>

<div class="assessments_news">
<div class="page-header">
<h2>Asesmen-asesmen yang tersedia</h2>
</div>
<?php

$type = "sasA";
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assessmentItem-grid',
	'dataProvider'=>$item_model->searchActive(),
	'ajaxUpdate'=>true,
	'updateSelector'=>'{page},',
	//'afterAjaxUpdate'=>'function(id, data){ console.log("page is is "+ data); }',
	//'filter'=>$item_model,

	'columns'=>array(
	
		'name',
		'description',
		//'group',
		array(
				'name'=>'Daftar',
				'type'=>'raw',
				'value'=>'CHtml::link(	
						"Daftar",
						"#",
						array(
							"submit" => $data->start_url ,' .
							 '"confirm" => "Are you sure?", 
							 "csrf"=>true,
							"params" => array("command" => "register_assessment","assessment"=>urlencode($data->id),"profile"=>Yii::app()->user->name,"group"=>$this->grid->dataProvider->data[$row]->group,),		
							)
						)',
				),
	),
)); 

?>
</div>

<br/>

<input type=button onClick='location.href="http://tao.ppsdm.com/tao/Main/login<?php echo '?profile=' . Yii::app()->user->name;?>"' value='click to go to test page'>

<br/>
<div class="page-header">
<h2>Asesmen-asesmen yang telah diambil</h2>
</div>
<?php 

		$user_id = User::model()->find('username=:username', array(':username'=>Yii::app()->user->name))->id;
		$profile_id = Profile::model()->getProfileid($user_id);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assessment-grid',
	'dataProvider'=>$model->getassessments($profile_id),
	'ajaxUpdate'=>true,
	'updateSelector'=>'{page},',
	//'filter'=>$model,
	'columns'=>array(

					array(
				'name'=>'assessment name',
				//'value'=> '$data->tao_delivery_label'
				'type'=>'raw',
				//'value'=>'CHtml::link("sasasa")',
				'value'=>'($data->note == "unpaid") ? $data->tao_test_label : CHtml::link($data->tao_test_label,$data->result_url . "?result=".urlencode($data->tao_delivery_result))',
				),
				

		'finish_time',
		'note',
		
						array(
						'class'=>'CButtonColumn',
			  'template'=>'{download}',
			  			   'header'=>'Unduh',
    // 'headerHtmlOptions'=>array('style'=>'width:10px;'),
      'htmlOptions' => array('style'=>'max-height:5px; text-align:center; width:10%;'),		
			   'buttons'=>array(
			   
               'download'=>array(

						'label'=>'',
						// 'url'=>'"http://127.0.0.1/psikotes/psikogram/index_pdfcrowd.php?result=" .urlencode($data->tao_delivery_result)',
						'url'=>'($data->note == "unpaid") ? "" : "http://public.ppsdm.com/tao/pdf/index_pdfcrowd.php?result=".urlencode($data->tao_delivery_result)',
						
                        // 'url'=>'$this->grid->controller->createAbsoluteUrl("http://www.google.com", array("id"=>$data->primaryKey))',
						
						// 'click'=>'js:function(){alert("halo");}',  
						//'imageUrl'=>Yii::app()->request->baseUrl.'/images/remove.png',
						 'imageUrl'=>'',
    'options'=>array( 'class'=>'icon-edit' ),
	'visible'=>'($data->note == "unpaid") ? "false" : "true"',
						 
						 
                         ),	

						 ),
		),

	),
)); 



?>