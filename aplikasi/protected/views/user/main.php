


<h1><?php echo Yii::t('strings', 'Welcome'); ?> <?php echo Yii::app()->user->name;?> !</h1>

<?php



		


$user_id =  Yii::app()->user->id;

echo '<br/><br/>';

	$profilemodel = new Profile;

	$profilemodel= ProfileController::loadProfile(Yii::app()->user->id);
	$profile_id = $profilemodel->id;
			$criteria = new CDbCriteria;
			$usermodel = new User;
			$criteria->condition='id="'.Yii::app()->user->id.'"';
			//$uploadmodel = Upload::model()->find($criteria);
			//$profilemodel = Profile::model()->find($criteria);
			
//print_r($profilemodel);
$url = "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->createUrl('profile/view');
	if (isset($profilemodel->last_name))
	{
		echo 'Registration COMPLETE<br/><br/>';
		}
		else {
			echo '<h3>Please <a href="'.$url.'"><span style="color:blue;">click here</span></a> to complete your registration</h3><br/>';
		}

		/*
			$criteria = new CDbCriteria;
			$uploadmodel = new Upload;
			$criteria->condition='profile_id="'.$profile_id.'" AND category="CV"';
			$uploadmodel = Upload::model()->find($criteria);
			
	if ($uploadmodel !='')
	{
		echo 'CV UPLOADED<br/><br/>';
		}
		else {
			echo 'Please upload your CV <br/><br/>';
		}

*/

//echo '<a href=""> add to tao</a>;
?>