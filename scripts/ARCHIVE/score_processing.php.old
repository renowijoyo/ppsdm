<?php include_once("DbHelper.php"); ?>


<?php

echo 'result : ' . $_GET['result'] . '<br/>';


$delivery_result = $_GET['result'];
$psikotes_con = mysqli_connect('localhost', 'root', '','psikotes') or die("Unable to connect to MySQL");
$que = 'select * from results where tao_delivery_result = "'. $delivery_result . '";';
$con = new MyDB();
		
$result = mysqli_query($psikotes_con,$que);

while ($row = mysqli_fetch_array($result)){
echo $row['scores_string'];
}

	$con->close();
?>