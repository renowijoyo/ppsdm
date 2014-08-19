<?php
ob_start();
date_default_timezone_set( 'Asia/Jakarta' );
class SiteController extends Controller
{

	public $layout='//layouts/ppsdm/index';
	//public $layout='//layouts/main';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

			  if ($this->isMobileBrowser())
					//echo 'yes it is mobile';
				 Yii::app()->theme = 'mobile';
				else
					//echo 'it is a desktop browser';
					 Yii::app()->theme = 'classic';
	
	
			if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('login'));
			$this->render('index');
		} else
			  $this->redirect(array('user/main'));
			  
			  

	}
	
	public function isMobileBrowser()
	{
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		return preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}


	public function actionLogout()
	{
		Yii::app()->user->logout();
		unset(Yii::app()->request->cookies['ppsdm_profile']);
		$this->redirect(Yii::app()->homeUrl);
	}
	
	

public function actionRegister()
	{

		$model=new RegisterForm;

		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];


					if ($model->validate()) //check if all form are filled and no duplicate value in table
					{
						$usermodel = new User;
				
						//INSERT into 3 tables (user, profile, contact)
						$random_number = sprintf("%04d",rand(0,9999));
							$usermodel->username = $model->email;
							$usermodel->status_id = 'unvalidated';
							$usermodel->password = $model->password;
							$usermodel->validation_code = $random_number;
							$usermodel->created = date( 'Y-m-d', time() );
							$usermodel->insert();
							
									$profile_model = new Profile;

									$profile_model->user_id = $usermodel->id;
									$profile_model->insert();
									$contact_model = new ProfileContact;
									$contact_model->profile_id = $profile_model->id;
									$contact_model->insert();
									
									$address_model = new ProfileAddress;
									$address_model->profile_id = $profile_model->id;
									$address_model->insert();
							//$url = $this->createUrl('user/index'); // user/index
							
								$result1 = Methods::new_testtaker($usermodel);	
								Methods::validationEmail($usermodel,$random_number);
								$this->redirect('thankyou');
					}
		}		
		$this->render('register',array('model'=>$model));	
	}
	
	public function actionApplication($id)
	{
		$applyform_model=new applyForm;

		if(isset($_POST['ApplyForm']))
		{
		
			$applyform_model->attributes = $_POST['ApplyForm'];
			$applyform_model->job_id = $id; //for job_id

		
			// validate user input and redirect to the previous page if valid
			// to apply: check if user is validated -> ask for password (authenticate)
			if($applyform_model->validate()) //just ask for password
			{
					if ($user_id = $applyform_model->isvalidated())
					{
						$this->redirect(array('site/byappauthenticate', 'user'=>$user_id, 'id'=>$id));
					} else { 
					$this->redirect(array('site/byappvalidate', 'user'=>$applyform_model->email, 'id'=>$id));
				}
			}
				
		}		
		
		$this->render('apply_form',array('model'=>$applyform_model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()) 
			{	
			// here is the code if all validation and authentication are ok
				if($model->hasvalidated() != 'unvalidated')
				{
					if($model->login()){
						
							
							$this->redirect(array('user/main'));
							}
					//echo 'login success';
				} else 
				{
					//if($model->login())
					$this->redirect(array('site/validate','id'=>$model->getId()));
				}
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionThankyou()
	{
		$this->render('pages/thankyou');
	}

	public function actionValidated()
	{
		$this->render('pages/validated');
	}
	
	public function actionTestadd()
	{
		echo CHtml::link('Continue',array('user/main'));
	}
	
	public function actionValidate($id)
	{

		$usermodel = new User;
	$validate_form = new ValidateForm;
	$criteria = new CDbCriteria;
	$criteria->condition='id="'.$id.'"';
	$usermodel = User::model()->find($criteria);
	
	
		if(isset($_POST['ValidateForm']))
		{
			$validate_form->attributes=$_POST['ValidateForm'];
			
			// validate user input and redirect to the previous page if valid
			if($validate_form->validate() && $validate_form->validateCode($id,$validate_form->validation_code))
					$this->redirect(array('site/validated'));
					//$this->redirect('validated');

					//$this->redirect(array('application/authenticate', 'user'=>$usermodel->id, 'id'=>$id));
				else
					echo 'validation code is wrong';
		}		
		$this->render('validate',array('model'=>$validate_form));
	}
	
	public function actionLupa()
	{
	
		if(isset($_POST['username']))
		{
			$password_reminder = '';
			//IF username does not exist
			
			//IF username exists
			
			$usermodel = new User;
			$criteria = new CDbCriteria;
			$criteria->condition='username="'.$_POST['username'].'"';
			$usermodel = User::model()->find($criteria);
			
			if (isset($usermodel)){
			$password_reminder = $usermodel->password;
			$message = "<p>Password anda: ".$password_reminder."</p>";
			$subject = "Password anda";
			$this->sendEmail($_POST['username'],$subject,$message);

			
			Yii::app()->user->setFlash('success','Your password has been sent to your email' );
			} else {
			
			Yii::app()->user->setFlash('success','That username does not exist' );
			
			}
			//$this->render('lupa');
		}		
		$this->render('lupa');
	}
	
	
	
	
	
	
	
	
	
	
	
/*	
public function actionByappvalidate($user,$id)
{

	$usermodel = new User;
	$validate_form = new ValidateForm;
	$criteria = new CDbCriteria;
	$criteria->condition='username="'.$user.'"';
	$usermodel = User::model()->find($criteria);


	if (isset($usermodel)) {

			if(isset($_POST['ValidateForm'])){

					$validate_form->attributes=$_POST['ValidateForm'];
					if ($validate_form->validateCode($usermodel->id,$validate_form->validation_code))
						$this->redirect(array('site/byappauthenticate', 'user'=>$usermodel->id, 'id'=>$id));
						else
							echo 'wrong validation code';

			}
	} else {
				$usermodel = new User;
				$random_number = sprintf("%04d",rand(0,9999));
					$usermodel->username = $user;
					$usermodel->status_id = '0';
					$usermodel->password = $random_number;
					$usermodel->validation_code = $random_number;
					$usermodel->created = date( 'Y-m-d', time() );
					$usermodel->insert();
							$profile_model = new Profile;
							$profile_model->user_id = $usermodel->id;
							$profile_model->insert();
					
					$message = "<h1>Terima kasih telah melakukan registrasi</h1><p>Kode validasi anda: ".$random_number."</p>";
					$subject = 'Kode validasi dan password registrasi PPSDM Portal';
					$this->sendEmail($user,$subject,$message);

	}
		
		$this->render('byappvalidate_form', array('model' => $validate_form));


}
	
*/
	
	
	
public function actionByappauthenticate($id, $user)
{

$model=new LoginForm;
$model->username = User::model()->getUsername($user);

	// if it is ajax validation request
	if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}

	// collect user input data
	if(isset($_POST['LoginForm']))
	{
		$model->attributes=$_POST['LoginForm'];
		// validate user input and redirect to the previous page if valid
		
		if($model->validate()) 
		{
		// here is the code if all validation and authentication are ok
			if($model->hasvalidated()) // check if username is exist
			{
				$application_model = new Application;
				$jobid = $this->isnew($id, $user);
				if ($jobid == 'none')
				{				
					$application_model->user_id = $user;
					$application_model->job_id= $id;
					$application_model->status_id='0';
					$application_model->referencing_site = '';
					$application_model->date_created = date( 'Y-m-d', time() );
					$application_model->insert();

					if($model->login()) // AFTER AUTHENTICATE AUTOMATICALLY LOGS IN
					$this->redirect(array('application/view','id'=>$application_model->id));
	
				} else {
					//echo 'you have already applied for this job';
					if($model->login()) // AFTER AUTHENTICATE AUTOMATICALLY LOGS IN
					$this->redirect(array('application/view','id'=>$jobid));
				}

			} else {
				echo 'this username doesnt exist';
			}
		}
	}
	// display the login form
	//	$this->render('login',array('model'=>$model));

	$this->render('authenticate_form', array('model' => $model));
}

public function isnew($id, $user_id)
{

	$model2= new Application;

	$criteria = new CDbCriteria;
	//$criteria->select='status';
	$criteria->condition='job_id="'.$id.'" AND user_id="'.$user_id.'"';
	$model2= Application::model()->find($criteria);

	
	if (isset($model2))
	return $model2->id; //a value already exist
	else {
		return 'none';
	}
}
	
	
	public function actionTest()
	{
	Methods::testEmail();
//		$this->render('test');
	}	
	
	
	
	
	
	
	
	
	
	
}
