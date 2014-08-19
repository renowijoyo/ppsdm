<?php

echo 'nama presiden kita : ' . $_POST['ans1'];
	
$score = 0;

if ($_POST['ans1'] == 'sby')
{
	$score++;
	echo ' BENAR';
	}
	else {
	echo ' SALAH';
	}

echo "<br/>";
echo 'Monas terletak di : ' . $_POST['ans2'];


if ($_POST['ans2'] == 'jakarta')
{
	$score++;
	echo ' BENAR';
	}
	else {
	echo ' SALAH';
	}


		
		echo '<br/>';
echo 'score = ' . $score;
?>