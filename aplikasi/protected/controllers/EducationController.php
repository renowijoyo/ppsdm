<?php

class EducationController extends Controller
{

//private $jurusan;
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','cancel','update','delete', 'admin','ajaxinstitution', 'ajaxattribute1','ajaxattribute2','ajaxgetinstitutionid'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','filter_school','filter_major'),
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
		$model=new Education;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Education']))
		{
			$model->attributes=$_POST['Education'];
			$model->profile_id= Profile::model()->getProfileid(Yii::app()->user->id);


		//	$model->institution_id = $this->getInstitutionid($_POST['academic_level_id'], $_POST['institution_name'] ,$_POST['attribute_1'], $_POST['attribute_2']);
/*						if($model->save())
				$this->redirect(array('profile/view'));
*/

			if ($model->validate())
			{
					echo 'save';
					if($model->save()) {$this->redirect(array('profile/view'));} 
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCancel()
	{
	$this->redirect(array('profile/view'));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
$model->institution_name = Institution::model()->getInstitutionModel($model->institution_id)->info;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Education']))
		{
			$model->attributes=$_POST['Education'];
			
			if($model->save())
			//	$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('profile/view'));
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
		$dataProvider=new CActiveDataProvider('Education');
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
		$model=new Education('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Education']))
			$model->attributes=$_GET['Education'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionFilter_school()
	{
	//echo 'filter school';
	
	
		if(Yii::app()->user->name == 'admin')
	{
	$this->layout='//layouts/ppsdm/admin';
	}
	
	
	
	
	
	
	
				$model=new Education('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Education']))
			$model->attributes=$_GET['Education'];

		$this->render('filter_school',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Education the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Education::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Education $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='education-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	

	

	
	
public function actionAjaxinstitution()
{

    $data=Institution::model()->findAll(array('select' => '*',
	'group'=>'name',
	'distinct'=>true,
	'condition' => 'academic_level_id LIKE ("%' . $_POST["Education"]["academic_level_id"].'%")'
	
	//select * from institution where academic_level_id LIKE ('%s1%')
	) 

				  );
 
    $data=array_merge(array('pilih institusi'=>''), CHtml::listData($data,'info','id'));
    foreach($data as $value=>$name)
    {
        echo CHtml::tag('option',
                   array('value'=>$name),CHtml::encode($value),true);
    }
}








public function actionAjaxattribute1()
{

    $data=Institution::model()->findAll(array('select' => '*',
	'group'=>'attribute_1',
	'distinct'=>true,
	'condition' => 'academic_level_id="' . $_POST["Education"]["academic_level_id"] . '" AND name="'. $_POST["Education"]["institution_name"]. '"'
	) 

				  );
 
    $data=array_merge(array('pilih jurusan'=>''), CHtml::listData($data,'attribute_1','attribute_1'));
    foreach($data as $value=>$name)
    {
        echo CHtml::tag('option',
                   array('value'=>$name),CHtml::encode($value),true);
    }
}





public function actionAjaxattribute2()
{
    $data=Institution::model()->findAll(array('select' => '*',
	'condition' => 'academic_level_id=' . $_POST["Education"]["academic_level_id"] . ' AND name="'. $_POST["Education"]["institution_name"]. '"' . ' AND attribute_1="'. $_POST["Education"]["attribute_1"]. '"'
	) 
				  );
 
    $data=array_merge(array(''=>''), CHtml::listData($data,'attribute_2','attribute_2'));
    foreach($data as $value=>$name)
    {
        echo CHtml::tag('option',
                   array('value'=>$value),CHtml::encode($name),true);
    }
}


public function actionAjaxgetinstitutionid()
{
    $data=Institution::model()->findAll(array('select' => '*',
	'condition' => 'academic_level_id=' . $_POST['academic_level_id'] . ' AND name="'. $_POST['institution_name']. '"' . ' AND attribute_1="'. $_POST['attribute_1']. '"' . ' AND attribute_2="'. $_POST['attribute_2']. '"'
	) 
				  );
 
    $data=CHtml::listData($data,'id','info');
	
	/*
    foreach($data as $value=>$name)
    {
		//echo CHtml::tag('option',
          //         array('value'=>$value),CHtml::encode($name),true);
		 echo '3';
    }
	*/

	//echo '<option value="">Pilih satu</option><option value="0">elektro</option><option value="1">komputer</option>';
	//print_r($data);
	
}




public function getInstitutionid($academic_level, $institution_name, $attribute_1, $attribute_2)
{
/*
	$user = new User;

	$criteria = new CDbCriteria;
	//$criteria->select='status';
	$criteria->condition='id="'.$id.'"';
	$user = User::model()->find($criteria);

	return $user->username;
	*/
	echo $academic_level . ' | ' . $institution_name . ' | ' . $attribute_1 . ' | ' . $attribute_2;

	
	$institution = new Institution;

	$criteria = new CDbCriteria;
	$criteria->select='*';
	//$criteria->condition='name="'.$institution_name.'" AND 	academic_level_id="'.$academic_level.'" AND attribute_1="'.$attribute_1.'" AND attribute_1="'.$attribute_2.'" ';
	$criteria->condition='name="'.$institution_name.'" AND academic_level_id="'.$academic_level.'" AND attribute_1="'.$attribute_1.'" AND attribute_2 = "'.$attribute_2.'"';

	$institution = Institution::model()->find($criteria);


	if (isset($institution))
	{
		echo $institution->id;
	} else {
		echo 'nooo';
	}
	//return $institution->id;
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

	}



public function actionFilter_major()
{
	echo 'filter major';
}


}
