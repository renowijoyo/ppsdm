<?php


abstract class ExtendUserModel extends CActiveRecord
{

public function validatePassword($password)
{
	return $password===$this->password; //compare $user->password with password from the form
}

public function getUsername($id)
{
	$user = new User;

	$criteria = new CDbCriteria;
	//$criteria->select='status';
	$criteria->condition='id="'.$id.'"';
	$user = User::model()->find($criteria);

	return $user->username;
}

}


?>