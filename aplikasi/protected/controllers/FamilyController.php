<?php

class FamilyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
		public $layout='//layouts/ppsdm/layout_2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
			'ownerContext', //make sure this application is owned by the user
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Family;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Family']))
		{
			$model->attributes=$_POST['Family'];
			$model->profile_id= Profile::model()->getProfileid(Yii::app()->user->id);

			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('profile/view'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Family']))
		{
			$model->attributes=$_POST['Family'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('profile/view'));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	/*
		$dataProvider=new CActiveDataProvider('Family');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		 $this->redirect(array('user/main'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Family('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Family']))
			$model->attributes=$_GET['Family'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Family the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Family::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Family $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='family-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function filterownerContext($filterChain)
	{
		if (isset($_GET['id']))
		{
			$model=$this->loadModel($_GET['id']);
			//$current_user_id = Yii::app()->user->id;
		
			if($model->profile_id == $this->loadProfile(Yii::app()->user->id)) {
			} else {
				throw new CHttpException(403, 'Youre not authorized to see this page');
			}
		} else {
			//throw new CHttpException(403, 'You have not create a profile');
		}
		$filterChain->run();
	}
	
	public static function loadProfile($id)
	{
	
	
		$criteria = new CDbCriteria;
		$profile_model = new Profile;
		$criteria->condition='user_id="'.$id.'"';
		$profile_model= Profile::model()->find($criteria);
		if (isset($profile_model))
			return $profile_model->id;
		else
			return false;;

//return $id;
	}
	
}
