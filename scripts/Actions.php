<?php
require_once('Config.php');
require_once("TaoHelper.php");

$taohelper = new TaoHelper;
echo 'this is Action <br/><br/>';

/*

if (isset($_POST['command'])) {
	$command = $_POST['command'];
	$http_type = "_POST";
} else if (isset($argv[1]) ){
	parse_str(implode('&', array_slice($argv, 1)), $_GET);
	$command = $_GET['command'];
} else {
	$command = $_GET['command'];
	$http_type = "_GET";
	}
*/

$command = $_REQUEST['command'];

switch ($command) {
    case 'new_testtaker':
		echo 'new testtaker';

		$hasil = $taohelper->newTesttaker($_REQUEST['username'],$_REQUEST['password'],$_REQUEST['group']);
		echo 'POST hasil : ' . $hasil;
        break;
		
    case 'eportfolioSignup':

		echo '<h2>Pendaftaran asesmen : ';
		echo $_REQUEST['group'];
		echo '</h2><br/>';

        $taohelper->groupSignup($_REQUEST['username'],$_REQUEST['group']);
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

		$taohelper->finishAssessment($delivery_object); // THIS COULD SLOW DOWN THE PROCESS
		break;		
		} 
				$taohelper->dbClose();
		
		


?>