<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangepasswordForm extends CFormModel
{
	public $username;
	public $current_password;
	public $new_password;
	public $confirm_new_password;


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
			array('username, current_password, new_password, confirm_new_password', 'required'),

			array('confirm_new_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>'new password do not match'),
		
					// password needs to be authenticated
			array('current_password', 'authenticate'),
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
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->current_password);
			if(!$this->_identity->authenticate())
				$this->addError('current_password','username atau password anda salah.');
		}
		
	}



	
}
