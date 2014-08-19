<?php

/*echo 'jawaban 1: ' . $_POST['soal1'] . '<br/>';
echo 'jawaban 1: ' . $_POST['soal2'] . '<br/>';
echo 'jawaban 1: ' . $_POST['soal3'] . '<br/>';
echo 'jawaban 1: ' . $_POST['soal4'] . '<br/>';
*/



$skor1 = 0;


if (isset($_POST['soal1']) && ($_POST['soal1'] == '2'))
	$skor1++;

if (isset($_POST['soal2']) && ($_POST['soal2'] == '2'))
	$skor1++;
if (isset($_POST['soal3']) && (strtolower($_POST['soal3']) == 'kpk'))
	$skor1++;
if (isset($_POST['soal4']) && (strtolower($_POST['soal4']) == 'bandung'))
	$skor1++;

	//echo 'dsdsds';
	//print_r($soal5);
	if (in_array('soekarno',$soal5))
	{
		//echo 'haha';
		if (in_array('soeharto',$soal5))
		{
			if (sizeof($soal5) == 2)
				$skor1++;
		}
	}
/*
if  (isset($_POST['soal5']) && ((strtolower($_POST['soal5'][0]) == 'soekarno') && (strtolower($_POST['soal5'][1]) == 'soeharto') && (!isset($_POST['soal5'][2])) ))
	$skor1++;
*/
//echo $skor1;


?>
