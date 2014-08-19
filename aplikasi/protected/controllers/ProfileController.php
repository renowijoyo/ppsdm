<?php

class ProfileController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/profile-column';
//public $layout='//layouts/ppsdm/user_main';
	public $layout='//layouts/ppsdm/layout_2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'userContext', // make sure the profile is owned by the user
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('education','view','create','update', 'cvupload','profilephotoupload', 'imageupload','delete','password','index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','password'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
	
	
$user = Yii::app()->getComponent('user');
$user->setFlash(
    'success',
    "<strong>Well done!</strong> You're successful in reading this."
);
$user->setFlash(
    'info',
    "<strong>click to change profile photo</strong>"
);
$user->setFlash(
    'warning',
    "<strong>Warning!</strong>File upload harus dalam bentuk jpg, png, atau gif dengan ukuran < 1MB"
);
$user->setFlash(
    'error',
    '<strong>Oh snap!</strong> Change something and try submitting again.'
);	
	
	
	
		$profile_id = Profile::model()->getProfileid(Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Education', array(
		'criteria'=>array(
		'condition'=>'profile_id =:cid',
		'params'=>array(':cid'=>$profile_id),
			),
			// 'pagination' => array('pageSize' => 5),
			'pagination'=>false,
		'sort' => array(
              'defaultOrder' => array(
                 'academic_level_id' => CSort::SORT_ASC
              ),
           ),
			
			)
		);
		
		$workhistory_model=new CActiveDataProvider('Workhistory', array(
		'criteria'=>array(
		'condition'=>'profile_id =:cid',
		'params'=>array(':cid'=>$profile_id),
			),
			 //'pagination' => array('pageSize' => 5),
			 'pagination'=>false,
		'sort' => array(
              'defaultOrder' => array(
                 'start_id' => CSort::SORT_ASC
              ),
           ),
			
			)
		);
		
		$family_model=new CActiveDataProvider('Family', array(
		'criteria'=>array(
		'condition'=>'profile_id =:cid',
		'params'=>array(':cid'=>$profile_id),
			),
			 //'pagination' => array('pageSize' => 5),
			 'pagination'=>false,
		'sort' => array(
              'defaultOrder' => array(
                 'start_id' => CSort::SORT_ASC
              ),
           ),
			
			)
		);
		
		
			$criteria = new CDbCriteria;
			$criteria->condition='profile_id="'.$profile_id.'"';
			$contact_model = ProfileContact::model()->find($criteria);
			
			if (!isset($contact_model))
				$contact_model=new ProfileContact;

			$criteria2 = new CDbCriteria;
			$criteria2->condition='profile_id="'.$profile_id.'"';
			$address_model = ProfileAddress::model()->find($criteria2);
			
			if (!isset($address_model))
				$address_model=new ProfileAddress;
				
				

		
		$this->render('view',array(
			'model'=>$this->loadModel(Yii::app()->user->id),
			'model2'=>$dataProvider,
			'contact_model' => $contact_model,
			'workhistory_model' => $workhistory_model,
			'family_model' => $family_model,
			'address_model' => $address_model,
		));
		
	}

	
	public function isExist()
	{
			$criteria = new CDbCriteria;
			$criteria->condition='user_id="'.Yii::app()->user->id.'"';
			$model = Profile::model()->find($criteria);
			if (isset($model))
				return $model->id;
			else
				return false;
				
	}
	
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Profile;
		$workhistory_model=new Workhistory ;
		$family_model=new Family;
		$contact_model=new ProfileContact;
		$address_model=new ProfileAddress;

//if ($profile_id=$this->isExist())
	//	{
		
	//		$this->redirect(array('update','id'=>$profile_id));
	//	}
		//else {
		$model->user_id = Yii::app()->user->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Profile']))
		{
			
			$model->attributes=$_POST['Profile'];
			if($model->save())
				$this->redirect(array('view'));
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
		//}
	
	}
	

	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
				$workhistory_model=new Workhistory ;
		$family_model=new Family;
		$contact_model=new ProfileContact;
		$address_model=new ProfileAddress;
		$user_model = new User;

		$model=$this->loadModel(Yii::app()->user->id);
		$contact_model = ProfileContact::model()->loadModel($model->id);
		$address_model = ProfileAddress::model()->loadModel($model->id);

		$user_model = User::model()->findByPk(Yii::app()->user->id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (!isset($contact_model))
		{			
			$contact_model=new ProfileContact;
						$contact_model->profile_id = $model->id;
						$contact_model->primary_type_id = NULL;
						$contact_model->secondary_type_id = NULL;
						$contact_model->insert();
		}
		if (!isset($address_model))
		{			
						$address_model=new ProfileAddress;
						$address_model->profile_id = $model->id;
						//$address_model->primary_type_id = NULL;
						//$address_model->secondary_type_id = NULL;
						$address_model->insert();
		}
		

		

		if(isset($_POST['Profile']) && isset($_POST['ProfileContact']) && isset($_POST['ProfileAddress']))
		{
			$model->attributes=$_POST['Profile'];
			$contact_model->attributes=$_POST['ProfileContact'];
			$address_model->attributes=$_POST['ProfileAddress'];
			
			if ($contact_model->validate())
			
			{
			//echo date( 'Y-d-m', strtotime($model->date_of_birth));
			
			$model->date_of_birth = str_replace('/', '-', $model->date_of_birth);
			
				$model->date_of_birth = date( 'Y-m-d', strtotime($model->date_of_birth) );
	
	//echo $model->date_of_birth;
	
				if ($address_model->validate()){
					if($model->save() && $contact_model->save() && $address_model->save()) {
						$this->redirect(array('view'));
					//	echo $model->date_of_birth;
						} else {
						echo 'failed';
						echo $model->date_of_birth;
						}
					}
			
				} else {
					echo 'contact NOT VALIDATED';
				}
		}
	//echo 'HHHHHHHHHHHHHHHHHHAAAAAAAAAAAA';
	//	echo $address_model->profile_id;
		$this->render('update',array(
			'model'=>$model,
			'contact_model'=>$contact_model,
			'address_model'=>$address_model,
		));

		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	/*
		$dataProvider=new CActiveDataProvider('Profile');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		
		 $this->redirect(array('user/main'));
	}
	
	public function actionPassword()
	{
	
		$changepassword_model=new ChangepasswordForm;
		$user_model = new User;
		
		$changepassword_model->username = Yii::app()->user->name;
		//$changepassword_model->current_password = 'reno';
		
		//$model=new User;
		

		
		if(isset($_POST['ChangepasswordForm']))
		{
		
			$changepassword_model->attributes=$_POST['ChangepasswordForm'];
			$user_model = User::model()->findByPk(Yii::app()->user->id);
			
			if($changepassword_model->validate())
			{
				$user_model->password = $changepassword_model->new_password;
				if ($user_model->save())
					{
						$this->redirect(array('view'));
					}
			} else {
				echo 'not validated';
			}

		}


	
		$this->render('rubahpassword',array(
			'model'=>$changepassword_model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Profile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Profile']))
			$model->attributes=$_GET['Profile'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Profile the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		//$model=Profile::model()->findByPk($id);
		// $id is user ID. must convert to profile id
		
	$criteria = new CDbCriteria;  
	$criteria->condition='user_id="'.$id.'"';
	
		$model = Profile::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
		
	}
	

	/**
	 * Performs the AJAX validation.
	 * @param Profile $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
public static function loadProfile($id)
	{
	
	
		$criteria = new CDbCriteria;
		$profile_model = new Profile;
		$criteria->condition='user_id="'.$id.'"';
		$profile_model= Profile::model()->find($criteria);
		if (isset($profile_model))
			return $profile_model;
		else
			return false;;

//return $id;
	}
	
	public function actionEducation()
	{
		//$dataProvider=new CActiveDataProvider('Education');
		
		$profile_id = Profile::model()->getProfileid(Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Education', array(
		'criteria'=>array(
		'condition'=>'profile_id =:cid',
		'params'=>array(':cid'=>$profile_id),
			),)
		);
		

			

		$this->render('education-index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function filteruserContext($filterChain)
	{
		if (isset($_GET['id']))
		{
		$current_user_id = Yii::app()->user->id;
		
		if($current_user_id == $_GET['id']) {
			//echo 'yuhuuu';
		} else {
		
			throw new CHttpException(403, 'Youre not authorized to see this page');
		}
	} else {
	
		//throw new CHttpException(403, 'You have not create a profile');
	}
		$filterChain->run();
	}

	
	
	
	
	
	
	
	
	public function actionProfilephotoupload()
	{
	
		$profile_photo_model = new FileUpload();
		$uploadmodel = new Upload();
		$profile_id = Profile::model()->getProfileid(Yii::app()->user->id);

						$criteria = new CDbCriteria;
			$criteria->condition='profile_id="'.$profile_id.'" AND category="profile_photo"';
			$uploadmodel = Upload::model()->find($criteria);
			$base_path = realpath(Yii::app()->basePath);
			
		//	$upload_path = $base_path . '\\upload\\';    // -- for windows
			$upload_path = $base_path . '/upload/profile_photo/';

			if (isset($uploadmodel))
			{
					$uploadmodel->filepath=$upload_path;
					$uploadmodel->filename=$profile_id.".png";
					
					$uploadmodel->save();
			} else {
			$uploadmodel = new Upload();
								$uploadmodel->category='profile_photo';
					//$uploadmodel->filepath=realpath(Yii::app()->basePath).'\\upload\profile_photo\\';
					$uploadmodel->filepath=$upload_path;
					$uploadmodel->filename=$profile_id.".png";
					$uploadmodel->profile_id=$profile_id;
					$uploadmodel->save();
			}

	}
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	public function actionCvupload()
	{

		
		$usermodel=$this->loadModel(Yii::app()->user->id);
		
		$model = new FileUpload();
		$uploadmodel = new Upload();
		
		$form = new CForm('application.views.fileUpload.uploadForm', $model);
if ($form->submitted('submit') && $form->validate()) {
            $form->model->image = CUploadedFile::getInstance($form->model, 'image');
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            //do something with your image here
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			//print_r($form);
			$base_path = realpath(Yii::app()->basePath);
			
			//$upload_path = $base_path . '\\upload\\';   //  -- for windows
			$upload_path = $base_path . '/upload/';
			//$form->model->image->saveAs($images_path . '\\upload\\' . $form->model->image);
			$form->model->image->saveAs($upload_path. ''. $usermodel->id. '.' . $form->model->image->getExtensionName());
			//echo $upload_path;
			
			
			
			
			
			$criteria = new CDbCriteria;
			$criteria->condition='profile_id="'.$usermodel->id.'" AND category="CV"';
			$uploadmodel = Upload::model()->find($criteria);
			if (isset($uploadmodel))
			{
					$uploadmodel->category='CV';
					$uploadmodel->filepath=$upload_path;
					$uploadmodel->filename=$form->model->image;
					$uploadmodel->save();
			}
			else {
					$uploadmodel = new Upload();
					$uploadmodel->profile_id=$usermodel->id;
					$uploadmodel->category='CV';
					$uploadmodel->filepath=$upload_path;
					$uploadmodel->filename=$form->model->image;
					$uploadmodel->save();
				
				}

			Yii::app()->user->setFlash('success', 'File Uploaded');
          //  $this->redirect(array('upload'));
        }

        $this->render('cvupload_form', array('form' => $form));
	
		
		
		
	}
	
	
	
	

}
