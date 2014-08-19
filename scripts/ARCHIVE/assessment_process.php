<?php
require_once("TaoHelper.php");

//echo $_GET['command'];

$taohelper = new TaoHelper;

if ($_GET['command'] == 'registration')
{
//CHECK IF USER ALREADY EXIST IN TAO. IF NOT CREATE NEW USER
		$user_existed = $taohelper->user_already_exist($_GET['profile']);
		if (!is_null($user_existed))
		{
			$taohelper->add_group_member($_GET['profile'],$_GET['group']);
		} else
		{
		
			echo 'no tao user of this profile yet';
		}
	
}



$back = $_SERVER['HTTP_REFERER'];

echo "<br/><input type=button onClick='location.href=\"".$back."\"' value='click here'>";

?>
