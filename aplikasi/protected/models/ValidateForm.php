<?php
Yii::import('application.extensions.phpmailer.JPhpMailer');
class ValidateForm extends CFormModel
{
	public $validation_code;
	
	public function rules()
	{
		return array(
			// username and password are required
			array('validation_code', 'required'),
			array('validation_code', 'numerical'),
			//array('email', 'is_exist'),
			// array('email', 'unique', 'className' => 'User', 'attributeName' => 'username', 'message'=>'This Email is already in use'),
		);
	}
	

	
	public function validateCode($user_id,$validation_code)
	{
		//echo $user_id . ' + ' . $validation_code;
	
		$usermodel = new User;
	
		$criteria = new CDbCriteria;
		//$criteria->select='validation_code';
		$criteria->condition='id="'.$user_id.'"';
		$usermodel= User::model()->find($criteria);
		
		//echo $usermodel->validation_code;	
		
		if($usermodel->validation_code===$validation_code)
		{
			//echo $usermodel->validation_code;
		//echo 'match';
			$usermodel->status_id = 'validated';
			//$usermodel->save();
			$usermodel->update(array('status_id'));
			return true;
		}
			else {
			$this->addError('validation_code','Kode validasi salah. Silakan coba lagi, periksa email Anda');
			return false;
			}
	}
	

}

?>