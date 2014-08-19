<?php
require_once('Config.php');
require_once("TaoHelper.php");

$taohelper = new TaoHelper;
echo 'this is taoaction <br/><br/>';

$testtaker_group = Config::TESTTAKER_GROUP;




if (isset($_POST['command']))
{

switch ($_POST['command']) {
    case 'new_testtaker':
	echo 'new testtaker';
        $hasil = $taohelper->newTesttaker($_POST['username'],$_POST['password'],$testtaker_group);
		echo 'POST hasil : ' . $hasil;
        break;
    case 'register_assessment':

		//echo $_SERVER["HTTP_REFERER"];
		echo '<h2>Pendaftaran asesmen : ';
		echo $_POST['group'];
		echo '</h2><br/>';
		//echo 'profile :' . $_POST['profile'];
        $taohelper->addGroupMember($_POST['profile'],$_POST['group']);
		
		
        break;
		
	case 'finish_assessment':
		
		$delivery_object = array(
		'tao_delivery_result'=>$_POST["tao_delivery_result"],
		'tao_delivery_execution'=>$_POST["tao_delivery_execution"],
				'tao_test'=>$_POST["tao_test"],
		'tao_test_label'=>$_POST["tao_test_label"],
		'tao_delivery'=>$_POST["tao_delivery"],
		'tao_delivery_label'=>$_POST["tao_delivery_label"],
		'tao_subject'=>$_POST["tao_subject"],
		'ppsdm_profile'=>$_POST["ppsdm_profile"],
		'ppsdm_assessment_id'=>$_POST["ppsdm_assessment_id"],
		'result_url'=>$_POST["result_url"],
		'group'=>$_POST["group"],
		'status'=>$_POST["status"],
		);
		//sleep(20);
		
		$taohelper->finishAssessment($delivery_object); // THIS COULD SLOW DOWN THE PROCESS
		//sleep(5);

		break;
		
		} 
		
}		
else if (isset($argv[1]) ){

		parse_str(implode('&', array_slice($argv, 1)), $_GET);
		
switch ($_GET['command']) {
    case 'new_testtaker':
		echo 'new testtaker';
        $hasil = $taohelper->newTesttaker($_GET['username'],$_GET['password'],$testtaker_group);
		echo 'GET hasil : ' . $hasil;
        break;
    case 'register_assessment':
		echo 'register assessment ';
		//echo $_POST['group'];
		//echo 'profile :' . $_POST['profile'];
        $taohelper->addGroupMember($_GET['profile'],$_GET['group']);
        break;
		
	case 'finish_assessment':
	
		$delivery_object = array(
		'tao_delivery_result'=>$_GET["tao_delivery_result"],
		'tao_delivery_execution'=>$_GET["tao_delivery_execution"],
		'tao_test'=>$_GET["tao_test"],
		'tao_test_label'=>$_GET["tao_test_label"],
		'tao_delivery'=>$_GET["tao_delivery"],
		'tao_delivery_label'=>$_GET["tao_delivery_label"],
		'tao_subject'=>$_GET["tao_subject"],
		'ppsdm_profile'=>$_GET["ppsdm_profile"],
		'ppsdm_assessment_id'=>$_GET["ppsdm_assessment_id"],
		'result_url'=>$_GET["result_url"],
		'group'=>$_GET["group"],
		'status'=>$_GET["status"],
		);
		//sleep(20);
		
		$taohelper->finishAssessment($delivery_object); // THIS COULD SLOW DOWN THE PROCESS
		
		
		//$taohelper->test($_GET['command'] . $_GET['ppsdm_profile']);
		break;
		
		}
		
		
} else {

switch ($_GET['command']) {
    case 'new_testtaker':
		echo 'new testtaker';
        $taohelper->newTesttaker($_GET['username'],$_GET['password'],$testtaker_group);
        break;
		}

}
		
				$taohelper->dbClose();
		
		


?>