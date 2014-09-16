<?php include_once("DbHelper.php"); ?>

<?php


echo 'RESULT ID : ' . $_GET['result'] . '<br/><br/>';

$delivery_result = $_GET['result'];

$true_count = 0;
$false_count = 0;
$unanswered_count = 0;
$index = 0;

$results_con = new MyDB('results');

$result = $results_con->getResult($delivery_result);
$result_set = mysqli_fetch_array($result);

$json =  $result_set['result_json'];
$json_array = json_decode($json);

echo 'size : ' . sizeof($json_array);
echo '<br/><br/>';
print_r($json_array);
echo '<br/><br/><br/>';
$max_values = array(23,41,23,32,14,23,41,23);
foreach ($json_array as $key => $item)
{


	$response_value = $item->RESPONSE;
//		echo $index+1 . '. '. $key . ' => ' . base64_decode($value);

				$response =  explode(';',trim(base64_decode($response_value), '[]'));
				$score =  base64_decode($item->SCORE);
				$falsecount = floor($score/10);
				$truecount = $score % 10;
				
				echo $index+1 . '. ' . $key.' RESPONSE : '. base64_decode($response_value) .' <br/>SCORE : '. $score;
				
				echo '<br/>' . 'TRUE = ' . $truecount ;
				echo '<br/>' . 'FALSE = ' . $falsecount;
				echo '<br/>' . '#answered = ' . sizeof($response);
				echo '<br/>' . 'MAX values = ' . $max_values[$index];
				echo '<br/>' . 'values LEFT= ' . ($max_values[$index] - $score);
				echo '<br/>' . 'MORE FALSE = ' . ($max_values[$index] - $score) % 10;
				echo '<br/>' . 'MORE TRUE = ' . floor(($max_values[$index] - $score) / 10);
				echo '<br/>' . 'TOTAL FALSE = ' . ($falsecount + ($max_values[$index] - $score) % 10);
				echo '<br/>' . 'TOTAL TRUE = ' . ($truecount + floor(($max_values[$index] - $score) / 10));
				
				
	echo '<br/><br/>';
	$index++;
	
	
}

//echo "<br/>true = " . $true_count;
//echo "<br/>false = " . $false_count;
//echo "<br/>unanswered = " . $unanswered_count; 
	$results_con->close();
?>


