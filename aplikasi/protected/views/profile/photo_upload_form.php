<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
 
<h1>Image Upload</h1>
 
<div class="form">
<?php echo $form; ?>
</div>
<?php
$this->menu=array(
//	array('label'=>'List Profile', 'url'=>array('index')),
	//array('label'=>'Create Profile', 'url'=>array('create')),
//	array('label'=>'Update Profile', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Profile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Profile', 'url'=>array('admin')),

	array('label'=>'Data personal', 'url'=>array('profile/update')),
	array('label'=>'cv upload', 'url'=>array('profile/cvupload')),
	array('label'=>'Pendidikan', 'url'=>array('profile/education', )),
);
?>