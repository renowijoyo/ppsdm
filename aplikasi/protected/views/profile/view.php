<?php
/* @var $this ProfileController */
/* @var $model Profile */


			$criteria = new CDbCriteria;
			$uploadmodel = new Upload();

			
			$profile_photo_model = new FileUpload();
			$form = new CForm('application.views.fileUpload.uploadForm', $profile_photo_model);
			$base_path = realpath(Yii::app()->basePath);
			
		//$upload_path = $base_path . '\\upload\\profile_photo\\';   //  -- for windows
		//$cv_upload_path = $base_path . '\\upload\\cv\\';
	
				$upload_path = $base_path . '/upload/profile_photo/';
			$cv_upload_path = $base_path . '/upload/cv/';
			
			$criteria->condition='profile_id="'.$model->id.'" AND category="profile_photo"';
					$uploadmodel = Upload::model()->find($criteria);
					


			if ($form->submitted('submit_profile_photo')) {
				if( $form->validate()) {
						$form->model->image = CUploadedFile::getInstance($form->model, 'image');
						

						if (isset($form->model->image)) {
							$form->model->image->saveAs($upload_path . $model->id. '.' . $form->model->image->getExtensionName());
						} else {
							echo 'choose image first';
						}

						
						$criteria = new CDbCriteria;
						$criteria->condition='profile_id="'.$model->id.'" AND category="profile_photo"';
						$uploadmodel = Upload::model()->find($criteria);

						if (isset($uploadmodel))
						{
								$uploadmodel->category='profile_photo';
								$uploadmodel->filepath=$upload_path;
								$uploadmodel->filename=$form->model->image;
								$uploadmodel->save();

						}
						else {
								$uploadmodel = new Upload();
								$uploadmodel->profile_id=$model->id;
								$uploadmodel->category='profile_photo';
								
								$uploadmodel->filepath=$upload_path;
								$uploadmodel->filename=$form->model->image;
								$uploadmodel->save();

							}

					  } else {
					$this->widget('bootstrap.widgets.TbAlert', array(
					'block' => true,
					'fade' => true,
					'closeText' => false, // false equals no close link
					'events' => array(),
					'htmlOptions' => array(),
					'userComponentId' => 'user',
					'alerts' => array( // configurations per alert type
						'warning' => array('block' => false, 'closeText' => false),
					),
			));

					  }
				}
	  
	  
	  
	  
	  
	  
	  			if (isset($uploadmodel)) {
			if ($uploadmodel->filename == NULL)
			{
				$path = $upload_path .'no_photo.png';
			} else
				$path = $upload_path . $model->id.'.'. pathinfo($uploadmodel->filename, PATHINFO_EXTENSION);
			//$path = $upload_path . $model->id.'.png';
			//echo pathinfo($uploadmodel->filename, PATHINFO_EXTENSION);
			} else {
				$path = $upload_path .'no_photo.png';
			}


			$yourImageUrl = Yii::app()->assetManager->publish($path);
?>

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		
		
		
		
		
	<?php	
		
		
		/************************  ini BAGIAN CV           ***************************************/
				$cv_model = new CvUpload();
				$form2 = new CForm('application.views.cvUpload.uploadCv', $cv_model);
				$yourImageUrl2 = 'EMPTY';
				
				$criteria->condition='profile_id="'.$model->id.'" AND category="CV"';
			$uploadmodel2 = Upload::model()->find($criteria);
			
								

		if ($form2->submitted('submit_cv') && $form2->validate()) {
		
		
					$form2->model->doc = CUploadedFile::getInstance($form2->model, 'doc');
					//$cv_upload_path = $base_path . '\\upload\\cv\\';   //  -- for windows


			//$form->model->image->saveAs($images_path . '\\upload\\' . $form->model->image);
			//IF image is ALREADY CHOSEN BEFORE
			if (isset($form2->model->doc)) {
				$form2->model->doc->saveAs($cv_upload_path . $model->id. '.' . $form2->model->doc->getExtensionName());
			} else {
				echo 'choose file first';
			}

			
					$criteria = new CDbCriteria;
			$uploadmodel2 = new Upload();
			$criteria->condition='profile_id="'.$model->id.'" AND category="CV"';
			$uploadmodel2 = Upload::model()->find($criteria);
			
			
			
			

			if (isset($uploadmodel2))
			{
					$uploadmodel2->category='CV';
					$uploadmodel2->filepath=$cv_upload_path;
					$uploadmodel2->filename=$form2->model->doc;
					$uploadmodel2->save();

			}
			else {
					$uploadmodel2 = new Upload();
					$uploadmodel2->profile_id=$model->id;
					$uploadmodel2->category='CV';
					
					$uploadmodel2->filepath=$cv_upload_path;
					$uploadmodel2->filename=$form2->model->doc;
					if ($uploadmodel2->save())
					{
					echo 'success';
					} else  {
					
						echo 'failed';
					}

				}

			//Yii::app()->user->setFlash('success', 'File Uploaded');

        }

			?>
			
			
		
		<legend>Personal Data</legend>

		<div style="width:100%; height:auto; overflow:hidden;">
		<span id="username_display"><?php echo Yii::app()->user->name;?></span>
		<span id="created_display"><?php echo Yii::t('strings', 'Created');?> : <?php 
		
		$tempID=Yii::app()->user->id;
		//echo $tempID;
echo Yii::app()->dateFormatter->format('MM/dd/yyyy', User::model()->find('id=:postID',array(':postID'=>$tempID,))->created);
//echo User::model()->find('id=:postID',array(':postID'=>$tempID,))->created;
?></span>
			<div  style="float: left; width:200px; margin-right:20px;">
		
				<div class="well" id="profile_photo" class="hidden hidden_input"><img style="width:auto; margin-left:auto, margin-right:auto, max-width:150px; height:auto; max-height:150px;" src="<?php echo $yourImageUrl; ?>" class="img-thumbnail">
					<div><?php echo Yii::t('strings', 'Click to change profile photo');?>. <br/>Format file jpg,png,bmp</div>
					
					<div class="errorMessage">		
					</div>
					<div id="upload_control" style="margin-left:0px;">	<?php echo $form;?> 
					
					</div>		
				</div>
		
		
		
		
		
			
			
				<div class="well" id="cv" class="hidden hidden_input">
					<span class="cv_preview">
				<?php
				
			
				
			if (isset($uploadmodel2)) {
				if ($uploadmodel2->filename == NULL)
				{
					$cv_path = $cv_upload_path .'no_photo.png';
					//echo '<button id="no_cv" type="button">upload CV</button>';
					echo '<div>CV belum di upload</div>';
				} else {
					$cv_path = $cv_upload_path . $model->id.'.'. pathinfo($uploadmodel2->filename, PATHINFO_EXTENSION);
					$yourImageUrl2 = Yii::app()->assetManager->publish($cv_path);
					$string_filename = (strlen($uploadmodel2->filename) > 20) ? substr($uploadmodel2->filename,0,17).'...' : $uploadmodel2->filename;
					echo '<a href="'. $yourImageUrl2 .'"><button type="button">Download '.$string_filename.'</button></a>';
					}
				} else {
					$cv_path = $cv_upload_path .'no_photo.png';
					//echo '<button id="no_cv" type="button">upload CV</button>';
						echo '<div>CV belum di upload</div>';
				}

				?>
					</span>
				
				
				<div class="errorMessage"></div>
				<div id="upload_control" style="margin-left:0px;">	
				<?php echo $form2;?>
				Format file jpg,png,bmp
				<button type="button" id="upload_cv_button" >Upload CV</button>
				
				</div> 
				</div>


				<!--div style="margin-left:0px;"><?php echo CHtml::button('Upload CV', array('submit' => array('profile/cvupload','id'=>Yii::app()->user->id))); ?></div-->

	</div>

	
		<div id="personal_detail" style=" margin-left:50px;  overflow:hidden">
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				//'user_id',
				'first_name',
				'last_name',
				//'date_of_birth',
		
		/*	array(
				'name'=>'grade',
				'value'=> function($model){
				return $model->grade;},
				'htmlOptions' => array('style'=>'width:10px;'),	
				),
				
			*/	

		
				array(
				'name' => 'date_of_birth',
		
        'model' => $model,
        'attribute' => 'date_of_birth',
		//'value'=>Yii::app()->dateFormatter->format('M/DD/yyyy', $model->date_of_birth),
		'value'=>$model->date_of_birth,
		'allowEmpty' => true,


    ),
				'place_of_birth',
				'gender_id',
				'religion_id',
				'nationality_id',
				'ethnicity_id',
				'marriage_status_id',
				'number_of_children',
			),
		)); ?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$contact_model,
			'attributes'=>array(
				'primary_no',
				'secondary_no',

			),
		)); ?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$address_model,
			'attributes'=>array(
				'country_id',
				'province_id',
				'city_id',
				'postal_code',
				'street_address',

			),
		)); ?>	

		</div>
		<div id="update_profile" style="float:right; margin-top:5px;">
		<a href="<?php  echo $this->createUrl('profile/password'); ?>"><button id="rubah_password">Rubah password</button></a>
		<a href="<?php  echo $this->createUrl('profile/update'); ?>"><button>Update Profil</button></a>
		<?php //echo CHtml::linkButton('Update Profil', array('submit' => array('profile/update'))); 
		?>
		<?php //echo CHtml::link('Update Profil', array('profile/update')); 
		?>
		<?php //echo CHtml::link('+ Pengalaman kerja',array('upload/profileimage'), array("style"=>"color: green;float:left;")); 
		?>
		</div>
</div>



	
	
<div id="upload_file_name"></div>
<input type="file" id="uploadFile" style="display:none" />
<div id="spinner">
</div>



<h2 style=""><?php echo Yii::t('strings', 'Education');?></h2><?php echo CHtml::link(Yii::t('strings', '+ Add Education'),array('education/create'), array("style"=>"color: green;float:left;")); ?>
<?php 

$institution_model = new Institution;


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'education-grid',
	'dataProvider'=>$model2,
	//'filter'=>$model2->model,
	'columns'=>array(
	
	
	
					array(
		'name'=>'academic_level_id',
		'value'=>function($model){
		//$academic_level_text = Reference::model()->getAcademicLevelText($model2->institution_id);
		return $model->academic_level_id;},
		//'htmlOptions' => array('style'=>'width:80px;'),	
						'htmlOptions' => array('style'=>'width:10%;text-align:center;'),	

		),
				
				

				array(
		'name'=>'institution_id',
		'value'=>function($model2){

		$institution_model = Institution::model()->getInstitutionModel($model2->institution_id);
		if ($institution_model->name != 'other')
			return $institution_model->info;
		else
			return $model2->attribute_2;
		},
				'htmlOptions' => array('style'=>'width:20%;'),	

		),
				




					array(
		'name'=>'attribute_1',
		'value'=> function($model2){
		//$institution_model = Institution::model()->getInstitutionModel($model2->institution_id);
		return $model2->attribute_1;},
		'htmlOptions' => array('style'=>'width:20%;'),	

		),



				array(
		'name'=>'start_year',
		'value' => function($model){
				return $model->start_year;},
		//'htmlOptions' => array('style'=>'width:10px;'),	
				'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	
			),
		
		
		
		
		
		array(
		'name'=>'graduate_year',
		'value' => function($model){
				return $model->graduate_year;},
		//'htmlOptions' => array('style'=>'width:10px;'),	
				'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	
			),
			
			
			
			array(
				'name'=>'grade',
				'value'=> function($model){
				return $model->grade;},
				//'htmlOptions' => array('style'=>'width:10px;'),	
						'htmlOptions' => array('style'=>'width:5%;text-align:center;'),	
				),
				'note',


				
				array(
						'class'=>'CButtonColumn',
			  'template'=>'{delete} {update}',
			  			   'header'=>'',
    // 'headerHtmlOptions'=>array('style'=>'width:10px;'),
      'htmlOptions' => array('style'=>'max-height:5px; text-align:center; width:5%;'),		
			   'buttons'=>array(
			   
               'delete'=>array(

                       //  'url'=>'$this->grid->controller->createUrl("/education/delete", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
						 // 'imageUrl'=>Yii::app()->request->baseUrl.'/images/remove.png',	
						'label'=>'',
						 
                         'url'=>'$this->grid->controller->createUrl("education/delete", array("id"=>$data->primaryKey))',
						// 'click'=>'js:function(){alert("halo");}',  
						//'imageUrl'=>Yii::app()->request->baseUrl.'/images/remove.png',
						 'imageUrl'=>'',
      'options'=>array( 'class'=>'icon-remove' ),
                         ),	
			   
        'update'=> array(
			'url'=>'$this->grid->controller->createUrl("education/update", array("id"=>$data->primaryKey))',
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-edit'),
        ),
						 ),
		),
		

	),
)); 

?>
<?php //echo CHtml::link(TbHtml::em('+ Add new education ', array('color' => TbHtml::TEXT_COLOR_INFO)),array('education/create')); 

?>

<h2 style=""><?php echo Yii::t('strings', 'Work History');?></h2><?php echo CHtml::link(Yii::t('strings', '+ Add Work History'),array('workhistory/create'), array("style"=>"color: green;float:left;")); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'workhistory-grid',
	'dataProvider'=>$workhistory_model,
	//'filter'=>$model2->model,
	'columns'=>array(
			'employer',
			'industry_id',
			'position',

							array(
				'name' => 'start_date',
		//'value'=>Yii::app()->dateFormatter->format('MM/dd/yyyy', $workhistory_model->start_date),
		//'value'=>array($workhistory_model,'start_date',),
		//'value'=>'$data->start_date',
		//'value'=>'date("m/d/Y", strtotime($data->start_date))',
    ),

			
							array(
				'name' => 'finish_date',
		//'value'=>'date("m/d/Y", strtotime($data->finish_date))',
    ),
	
			'description',

				array(	
					'class'=>'CButtonColumn',
					'template'=>'{delete} {update}',
			  		  'header'=>'',
      'htmlOptions' => array('style'=>'max-height:5px; text-align:center; width:5%;'),	
			   'buttons'=>array(
			   
               'delete'=>array(
                         'url'=>'$this->grid->controller->createUrl("workhistory/delete", array("id"=>$data->primaryKey))',
						 'click'=>'js:function(){alert("halo");}',  
						 	'label'=>'',
						//'imageUrl'=>Yii::app()->request->baseUrl.'/images/remove.png',
						 'imageUrl'=>'',
      'options'=>array( 'class'=>'icon-remove' ),						 
						//'options' => array('ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}')),						 
                         ),
        'update'=> array(
			'url'=>'$this->grid->controller->createUrl("workhistory/update", array("id"=>$data->primaryKey))',
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
						 
						 ),
		),


	),
)); 

?>

<?php 
//echo CHtml::link(TbHtml::em('+ Add new work history ', array('color' => TbHtml::TEXT_COLOR_INFO)),array('workhistory/create')); 


?>

<h2 style=""><?php echo Yii::t('strings', 'Family');?></h2><?php echo CHtml::link(Yii::t('strings', '+ Add Family'),array('family/create'), array("style"=>"color: green;float:left;")); ?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'family-grid',
	'dataProvider'=>$family_model,
//	'filter'=>$model2->model,

	'columns'=>array(
		//'id',
		//'profile_id',
		'name',
		'relation_type_id', 
		array(
			'class'=>'CButtonColumn',
			
					'template'=>'{delete} {update}',
			  		  'header'=>'',
      'htmlOptions' => array('style'=>'max-height:5px; text-align:center; width:5%;'),		
			   'buttons'=>array(
			   
               'delete'=>array(
                         'url'=>'$this->grid->controller->createUrl("family/delete", array("id"=>$data->primaryKey))',
						//  'imageUrl'=>Yii::app()->request->baseUrl.'/images/remove.png',
						 'imageUrl'=>'',
						 	'label'=>'',
      'options'=>array( 'class'=>'icon-remove' ),							  
						  //'click'=>'function(){alert("dsds");}',
						//  'click'=>'function(){alert("Going down!");}',
						//  'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
						//'options' => array('ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}')),						 
                         ),	
        'update'=> array(
			'url'=>'$this->grid->controller->createUrl("family/update", array("id"=>$data->primaryKey))',
            'label'=>'',
            'imageUrl'=>'',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
						 ),

		),
	),

));

?>


























































<script type="text/javascript">

$(document).ready(function()
{


$(document).on('click','#workhistory-grid a.icon-remove', function() {
if(!confirm('Are you sure you want to delete this item?')) return false;
});
$(document).on('click','#family-grid a.icon-remove', function() {
if(!confirm('Are you sure you want to delete this item?')) return false;
});
$(document).on('click','#education-grid a.icon-remove', function() {
if(!confirm('Are you sure you want to delete this item?')) return false;
});


$("input[name='submit_profile_photo']").hide();
$("input[name='submit_cv']").hide();
$(".field_image").hide();
$(".field_doc").hide();


  $(".hidden_input").removeClass("hidden");


});

$(".img-thumbnail").click(function(){
//alert('clicked');
$("#FileUpload_image").trigger("click")	;
});

$("#FileUpload_image").change(function()
{

//$("input[name='submit_profile_photo']").show();
$("input[name='submit_profile_photo']").trigger("click");

});



$("#upload_cv_button").click(function(){
//alert('sa');
$("#CvUpload_doc").trigger("click")	;
});

$("#CvUpload_doc").change(function() {
	//alert('sa');
	$("input[name='submit_cv']").trigger("click");
});



</script>




<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/spin.js"></script>

<script type="text/javascript">
var opts = {
  lines: 13, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
};
var target = document.getElementById('spinner');
var spinner = new Spinner(opts).stop(target);


$("form").submit(function() {
//alert("subimita");
spinner.spin(target);
});




</script>