<?php
require_once('Config.php');
require_once("TaoHelper.php");


echo 'this is taoaction <br/><br/>';
$taohelper = new TaoHelper;
$testtaker_group = Config::TESTTAKER_GROUP;

$username = $_POST['username'];
$password = $_POST['password'];

switch ($_POST['command']) {
    case 'new_testtaker':
	//echo 'test taker';
	//echo $testtaker_group;
        $taohelper->newTesttaker($username,$password,$testtaker_group);
        break;
    case 'register_assessment':
		echo 'register assessment';
        $taohelper->addGroupMember($_POST['profile'],$_POST['group']);
        break;
		
	case 'finish_assessment':
		$delivery_object = array(
		'tao_delivery_result'=>$_POST["tao_delivery_result"],
		'tao_delivery_execution'=>$_POST["tao_delivery_execution"],
		'tao_delivery'=>$_POST["tao_delivery"],
		'tao_delivery_label'=>$_POST["tao_delivery_label"],
		'tao_subject'=>$_POST["tao_subject"],
		'ppsdm_profile'=>$_POST["ppsdm_profile"],
		'ppsdm_assessment_id'=>$_POST["ppsdm_assessment_id"],
		'status'=>$_POST["status"],
		);
		//sleep(20);
		
		$taohelper->finishAssessment($delivery_object); // THIS COULD SLOW DOWN THE PROCESS
		$taohelper->dbClose();
		break;
		
}

?>