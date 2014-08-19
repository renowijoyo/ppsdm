<?php
Yii::import('application.extensions.phpmailer.JPhpMailer');
class RegisterForm extends CFormModel
{
	public $email;
	public $id;
	public $password;

	
	public function rules()
	{
		return array(
			// username and password are required
			array('email, password', 'required'),
			array('email', 'email'),
			//array('email', 'is_exist'),
			 array('email', 'unique', 'className' => 'User', 'attributeName' => 'username', 'message'=>'This Email is already in use'),
		);
	}
	

/*	public function isvalidated()
	{
		
		$usermodel = new User;
	
		$criteria = new CDbCriteria;
		$criteria->condition='username="'.$this->email.'"';
		$usermodel= User::model()->find($criteria);

		if (isset($usermodel) && ($usermodel->status_id != 'unvalidated'))
			return $usermodel->id;
		else
			return false;
		

	}
	
	*/
}

?>