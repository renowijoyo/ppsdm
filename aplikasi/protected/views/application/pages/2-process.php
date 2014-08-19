<?php

echo 'nama presiden kita : ' . $_POST['ans1'];
	
$score = 0;

if ($_POST['ans1'] == 'soekarno')
{
	$score++;
	echo ' BENAR';
	}
	else {
	echo ' SALAH';
	}

echo "<br/>";
echo 'Monas terletak di : ' . $_POST['ans2'];


if ($_POST['ans2'] == 'bandung')
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