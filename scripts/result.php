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
$score =  $result_set['scores_string'];
$score_array = json_decode($score);

foreach ($score_array as $item)
{
	$key = key($item);

	$value = $item->$key;
		echo $index+1 . '. '. $key . ' => ' . $value;
	echo '<br/>';
	
			if ($value > 0) { //kalau positif berarti true
					$true_count++;
				} else if ($value < 0) //negatif berarti salah
				{
					$false_count++; 
				} else { //selain itu bearti tidak dijawab
					$unanswered_count++;
				}
	$index++;
	
	
}

echo "<br/>true = " . $true_count;
echo "<br/>false = " . $false_count;
echo "<br/>unanswered = " . $unanswered_count; 
	$results_con->close();
?>


