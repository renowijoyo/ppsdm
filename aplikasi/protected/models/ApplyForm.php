<?php


class ApplyForm extends CFormModel
{
	public $email;
	public $job_id;
	public $referring_site;
	


	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'email'),
			// password needs to be authenticated
			array('email', 'check'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function check($attribute,$params)
	{/*
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}*/
		
	}
	
	public function isvalidated()
	{
		
		$usermodel = new User;
	
		$criteria = new CDbCriteria;
		$criteria->condition='username="'.$this->email.'"';
		$usermodel= User::model()->find($criteria);

		if (isset($usermodel) && ($usermodel->status_id == 1))
			return $usermodel->id;
		else
			return false;
		

	}

	
}
?>