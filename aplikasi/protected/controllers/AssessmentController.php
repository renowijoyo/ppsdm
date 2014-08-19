<?php

class AssessmentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','load','processresult','index'),
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
		$model=new Assessment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Assessment']))
		{
			$model->attributes=$_POST['Assessment'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Assessment']))
		{
			$model->attributes=$_POST['Assessment'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*
		$dataProvider=new CActiveDataProvider('Assessment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		
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
    "<strong>Warning!</strong> Duplicate Item. You've taken this assessment"
);
$user->setFlash(
    'error',
    '<strong>Oh snap!</strong> Change something and try submitting again.'
);	

		/*
		$assessmentitem_model=new CActiveDataProvider('AssessmentItem', array(
		'criteria'=>array(
		'condition'=>'profile_id =:cid',
		'params'=>array(':cid'=>$profile_id),
			),
			 //'pagination' => array('pageSize' => 5),
			 'pagination'=>false,
		'sort' => array(
              'defaultOrder' => array(
                // 'start_id' => CSort::SORT_ASC
              ),
           ),
			
			)
		);
*/
//$assessment_item_model = new AssessmentItem('search');

		
			$model=new Assessment('search');
			//$model->unsetAttributes();  // clear any default values
			$this->render('index',array(
				'model'=>$model,
				//'assessment_item'=>$assessment_item_model,
			));
			
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Assessment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Assessment']))
			$model->attributes=$_GET['Assessment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Assessment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Assessment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function actionLoad($id)
	{
	
		//echo $id;
		
				$this->render('load',array('profile'=>Profile::loadProfile($id),));
		
		//		$this->render('load');
	
	}
	
	public function actionProcessresult()
	{
	
		$user = Yii::app()->getComponent('user');
$user->setFlash(
    'unfinished',
    "<strong>You have not finished!</strong> You must work the assessment from the beginning. "
);
$user->setFlash(
    'warning',
    "<strong>Warning!</strong>Duplicate"
);
$user->setFlash(
    'norecord',
    "<strong>No pending / unfinished assessment</strong>"
);


		$this->render('processresult');


	}
	/**
	 * Performs the AJAX validation.
	 * @param Assessment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='assessment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
}
