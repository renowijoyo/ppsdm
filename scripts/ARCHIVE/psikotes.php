<?php include_once("DbHelper.php"); ?>

<?php

$delivery_result = $_GET['result'];
//$delivery_result = "http://127.0.0.1/tao/local.rdf#i140706599496585611";

//$delivery_result = "http://127.0.0.1/tao/local.rdf#i1407094221762312196";

$true_count = 0;
$false_count = 0;
$unanswered_count = 0;
$counter = 0;

$answered_count_array = array();
$answered_count = 0;

$results_con = new MyDB('results');

$result = $results_con->getResult($delivery_result);
$result_set = mysqli_fetch_array($result);



					$no_pemeriksaan = substr($delivery_result,strrpos($delivery_result,'#'));
					$nama = $result_set['ppsdm_profile'];
					$ttl = "15 April 1997";
					$jenis_kelamin = "Perempuan";
					$pendidikan = "SMA";
					$tgl_pemeriksaan = "7 Juli 2014";
					$tujuan_pemeriksaan = $result_set['tao_delivery_label'];
					

$score =  $result_set['scores_string'];
$score_array = json_decode($score);


$subsets = array (
				array('subtest 1' => 13),
				array('subtest 2' => 14),
				array('subtest 3' => 13),
				array('subtest 4' => 10),
				array('subtest 5' => 40), //90
				array('subtest 6' => 20),
				array('subtest 7' => 40),//150
			array('subtest 8' => 40), //190
			array('subtest 9' => 25), //215
			array('subtest 10' => 40), //255
			array('subtest 11' => 20), //total  275
);
$truefalse_array = array();

$subset_score = array();
$subset_index = 0;
$subset_item_counter = 0;

foreach ($score_array as $item)
{
	$key = key($item);

	$value = $item->$key;
	echo $key . ' => ' . $value . '<br/>';
	
			if ($value > 0) { //kalau positif berarti true
					$true_count++;
				} else if ($value < 0) //negatif berarti salah
				{
					$false_count++; 
				} else { //selain itu bearti tidak dijawab
					$unanswered_count++;
				}
	$subtest_key = key($subsets[$subset_index]);
	if ($subset_item_counter + 1 < $subsets[$subset_index][$subtest_key])
	{
		$subset_item_counter++;
	} else { //summary setiap subtest
		
		$truefalse_array[$subtest_key] =
		array(
		'true' => $true_count,
		'false' => $false_count,
		'unanswered' => $unanswered_count
		);
		//$answered_count_array[$subtest_key] = $true_count + $false_count;
		$answered_count_array[$subset_index] = $true_count + $false_count;
		//$answered_count = $true_count + $false_count;
	
		echo '<br/> ============ '.$subtest_key.' ========='.$truefalse_array[$subtest_key]["true"].'============'. $answered_count_array[$subset_index] / ($true_count + $false_count + $unanswered_count).'=== <br/>';
		$answered_count = $answered_count + $true_count + $false_count + $unanswered_count;
		$true_count = 0;
		$false_count = 0;
		$unanswered_count = 0;
		$subset_item_counter = 0;
		
			$subset_index++;	
	}
	
	$counter++;
	
}

//echo "<br/>true = " . $true_count;
//echo "<br/>false = " . $false_count;
//echo "<br/>unanswered = " . $unanswered_count; 
//echo "<br/>counter = " . $counter; 
//print_r($truefalse_array); 
print_r($answered_count_array);

echo array_sum($answered_count_array) / $answered_count;
//echo sizeof($truefalse_array);
			
$score_array = array();

$score_array['inteligensi_umum'] = 0;
$score_array['pengetahuan_umum'] = 0;
$score_array['daya_analisa_sintesa'] = 0;
$score_array['penalaran_verbal'] = 0;
$score_array['orientasi_pandang_ruang'] = 0;
$score_array['kemampuan_numerik'] = 0;
$score_array['klasifikasi_dan_diferensiasi'] = 0;
$score_array['kemampuan_dasar_keteknikan'] = 0;

$score_array['kecepatan_kerja'] = 0;
$score_array['ketelitian_kerja'] = 0;
$score_array['konsentrasi'] = 0;

$score_array['stabilitas_emosi'] = 0;
$score_array['penyesuaian_diri'] = 0;
$score_array['hubungan_interpersonal'] = 0;




/*
foreach($truefalse_array as $baris)
{
$total_dijawab = 0;
	$total_dijawab = $total_dijawab + $baris[0] + $baris[1];
	//echo 'total dijawab : ' . $total_dijawab;
	//echo '<br/>';
//	echo 'total pertanyaan : ' . $baris[2];
	//echo '<br/>';
	$sum_total_dijawab = $sum_total_dijawab + ($total_dijawab / $baris[2] * 100);
	//echo 'persentasi dijawab : ' . $total_dijawab / $baris[2] * 100;
	//echo '<br/><br/>';
}

*/

$score_array['pengetahuan_umum'] = $results_con->scale('20to7',$results_con->scale('7_info',$truefalse_array['subtest 7']['true']));
$score_array['daya_analisa_sintesa'] = round(($results_con->scale('20to7',$results_con->scale('8_anv',$truefalse_array['subtest 8']['true'])) + $results_con->scale('20to7',$results_con->scale('9_arit',$truefalse_array['subtest 9']['true'])) + $results_con->scale('20to7',$results_con->scale('5_tiu',$truefalse_array['subtest 5']['true'])))/3,0);
$score_array['penalaran_verbal'] = $results_con->scale('20to7',$results_con->scale('8_anv',$truefalse_array['subtest 8']['true']));
$score_array['orientasi_pandang_ruang'] = $results_con->scale('20to7',$results_con->scale('5_tiu',$truefalse_array['subtest 5']['true']));
$score_array['kemampuan_numerik'] = $results_con->scale('20to7',$results_con->scale('9_arit',$truefalse_array['subtest 9']['true']));
$score_array['klasifikasi_dan_diferensiasi'] = $results_con->scale('20to7',$results_con->scale('10_adk4',$truefalse_array['subtest 10']['true']));
//$score_array['kemampuan_dasar_keteknikan'] = $con->scale('20to7',$con->scale('11_e',$truefalse_array['subtest 11'][0]));

$score_array['kecepatan_kerja'] = $results_con->scale2('1to7',(array_sum($answered_count_array) / $answered_count));
$score_array['ketelitian_kerja'] = $results_con->scale2('1to7',100*$truefalse_array['subtest 1']['true'] / ($truefalse_array['subtest 1']['true'] +  $truefalse_array['subtest 1']['false']));
$score_array['konsentrasi']=($score_array['ketelitian_kerja'] + $score_array['kecepatan_kerja'])/2;

$score_array['stabilitas_emosi'] = $results_con->scale2('130to7',130);
$score_array['hubungan_interpersonal'] = $results_con->scale('20to7',$results_con->scale('6_ist',$truefalse_array['subtest 6']['true']));
$score_array['penyesuaian_diri'] = round(($score_array['pengetahuan_umum'] + $score_array['klasifikasi_dan_diferensiasi'] + $score_array['penalaran_verbal'] + (3*$score_array['hubungan_interpersonal']))/6);



//ALL Score harus sudah selesai di titik ini

$jumlah_benar_1_4 = 0;



//Penilaian
$a1 = $score_array['inteligensi_umum']; //intelignensi umum
$a2 = $score_array['pengetahuan_umum'];
$a3 = $score_array['daya_analisa_sintesa'];
$a4 = $score_array['penalaran_verbal'];
$a5 = $score_array['orientasi_pandang_ruang'];
$a6 = $score_array['kemampuan_numerik']; //kemampuan numerik
$a7 = $score_array['klasifikasi_dan_diferensiasi']; //klasifikasi dan diferensiasi

$b1 = $score_array['kecepatan_kerja']; //kecepatan kerja
$b2 = $score_array['ketelitian_kerja']; //ketelitian kerja
$b3 = $score_array['konsentrasi']; //konsentrasi

$c1 = $score_array['stabilitas_emosi']; //stabilitas emosi
$c2 = $score_array['penyesuaian_diri']; //penyesuaian diri
$c3 = $score_array['hubungan_interpersonal']; //hubungan interpersonal

$arah_minat = "ASI";


	$results_con->close();

	//$con->close();
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="psikogram_files/filelist.xml">

<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id="psikogram_21287_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7621287
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8621287
	{
	padding: 0px;
	mso-ignore: padding;
	color: windowtext;
	font-size: 9pt;
	font-weight: 400;
	font-style: normal;
	text-decoration: none;
	font-family: Arial, sans-serif;
	mso-font-charset: 0;
	mso-number-format: General;
	text-align: left;
	vertical-align: top;
	mso-background-source: auto;
	mso-pattern: auto;
	white-space: nowrap;
}
.xl8721287
	{
	padding: 0px;
	mso-ignore: padding;
	color: windowtext;
	font-size: 9pt;
	font-weight: 400;
	font-style: normal;
	text-decoration: none;
	font-family: Arial, sans-serif;
	mso-font-charset: 0;
	mso-number-format: General;
	text-align: general;
	vertical-align: top;
	mso-background-source: auto;
	mso-pattern: auto;
	white-space: nowrap;
}
.xl8821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8921287
	{
	padding: 0px;
	mso-ignore: padding;
	color: windowtext;
	font-size: 9pt;
	font-weight: 400;
	font-style: normal;
	text-decoration: none;
	font-family: Arial, sans-serif;
	mso-font-charset: 0;
	mso-number-format: General;
	text-align: general;
	vertical-align: top;
	border-top: none;
	border-right: none;
	border-bottom: 2.0pt double windowtext;
	border-left: none;
	mso-background-source: auto;
	mso-pattern: auto;
	white-space: nowrap;
}
.xl9021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:7.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:7.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9721287
	{
	padding: 0px;
	mso-ignore: padding;
	color: windowtext;
	font-size: 9pt;
	font-weight: 400;
	font-style: normal;
	text-decoration: none;
	font-family: Arial, sans-serif;
	mso-font-charset: 0;
	mso-number-format: 0%;
	text-align: left;
	vertical-align: top;
	mso-background-source: auto;
	mso-pattern: auto;
	white-space: nowrap;
}
.xl9821287
	{
	padding: 0px;
	mso-ignore: padding;
	color: windowtext;
	font-size: 9pt;
	font-weight: 400;
	font-style: normal;
	text-decoration: none;
	font-family: Arial, sans-serif;
	mso-font-charset: 0;
	mso-number-format: 0%;
	text-align: left;
	vertical-align: top;
	border-top: none;
	border-right: none;
	border-bottom: 2.0pt double windowtext;
	border-left: none;
	mso-background-source: auto;
	mso-pattern: auto;
	white-space: nowrap;
}
.xl9921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:"\[$-421\]dd\\ mmmm\\ yyyy\;\@";
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:"\[$-421\]dd\\ mmmm\\ yyyy\;\@";
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl14921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl15021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl15121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl15221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl15321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl15921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl16921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl17021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl17121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl17221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl17321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl17421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl17521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:2.0pt double windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl17621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl17721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl17821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:2.0pt double windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl17921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl18021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:normal;}
.xl18121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl18221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl18321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl18421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl18521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl18621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl18721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Wingdings;
	mso-generic-font-family:auto;
	mso-font-charset:2;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl18821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl18921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl19021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl19121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:2.0pt double windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl19921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:36.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl20021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:2.0pt double windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:2.0pt double windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20421287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20521287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl20621287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl20721287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl20821287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl20921287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl21021287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl21121287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl21221287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl21321287
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:2.0pt double windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212871 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212872 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212873 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212874 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212875 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl135212876 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212871 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212872 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212873 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212874 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212875 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212876 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212877 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212878 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111212879 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128710 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128711 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128712 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128713 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128714 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128715 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128716 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128717 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128718 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl95212871 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212872 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212873 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212874 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212875 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212876 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1112128719 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128720 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128721 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128722 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128723 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128724 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128725 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128726 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128727 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128728 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128729 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128730 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212871 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212872 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212873 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212874 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212875 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212876 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128731 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128732 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128733 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128734 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl95212877 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1112128735 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1112128736 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102212877 {padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Narrow", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:2.0pt double windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
#psikogram_21287 .xl6521287 tr .xl13521287 {
	font-size: 9pt;
}
#psikogram_21287 .xl6521287 tr .xl13721287 {
	font-size: 9pt;
}
-->
</style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="psikogram_21287" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=703 class=xl6521287
 style='border-collapse: collapse; table-layout: fixed; width: 518pt; font-size: 9px;'>
 <col class=xl6521287 width=19 span=37 style='width:14pt'>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
   <td colspan=37 height=35 class=xl7521287 width=703
  style='height:35.0pt;width:518pt'>PSIKOGRAM HASIL
     PSIKOTES DAN TES MINAT SISWA</a></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
   <td colspan=24 rowspan=2 height=10 class=xl12321287 width=703
  style='border-right: .5pt solid black; border-bottom: .5pt solid black; height: 10.0pt; width: 336pt; font-size: 10pt;'>IDENTITAS PESERTA</td>
   <td colspan=13 class=xl13121287 width=703 style='border-right: 2.0pt double black; border-bottom: .5pt solid black; width: 182pt; font-size: 9pt;'>KETERANGAN</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
   <td colspan=9 height=10 class=xl11821287 width=703 style='border-right: .5pt solid black; height: 10.0pt; border-left: none; width: 126pt; font-size: 9pt;'>TARAF</td>
   <td colspan=4 class=xl11621287 width=703 style='border-right:2.0pt double black;
  border-left:none;width:56pt'>IQ</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height: 10.0pt; font-size: 9pt;'><span
  style='mso-spacerun:yes'> </span>Nomor Pemeriksaan</td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl13521287 style='border-right:.5pt solid black'><?php echo "$no_pemeriksaan"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>7 : Jauh di atas rata-rata<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>130&gt;</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height: 10.0pt; font-size: 9pt;'><span
  style='mso-spacerun:yes'> </span>Nama Lengkap</td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl13721287 style='border-right:.5pt solid black'><?php echo "$nama"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>6 : Di atas rata-rata</td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>115 – 130</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height:10.0pt'><span
  style='mso-spacerun:yes'> </span>Tanggal Lahir<span
  style='mso-spacerun: yes; font-size: 9pt;'> </span></td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl13921287 style='border-right:.5pt solid black'><?php echo "$ttl"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>5 : Rata-rata batas atas</td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>105 – 115</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height:10.0pt'><span
  style='mso-spacerun: yes; font-size: 9pt;'> </span>Jenis Kelamin</td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl13721287 style='border-right:.5pt solid black'><?php echo "$jenis_kelamin"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>4 : Rata-rata<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>95 – 105</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height:10.0pt'><span
  style='mso-spacerun: yes; font-size: 9pt;'> </span>Pendidikan<span style='mso-spacerun:yes'> 
  </span>Terakhir</td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl15921287 style='border-right:.5pt solid black'><?php echo "$pendidikan"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>3 : Rata-rata batas bawah</td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>85 – 95</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl11521287 style='height:10.0pt'><span
  style='mso-spacerun: yes; font-size: 9pt;'> </span>Tgl. Pemeriksaan</td>
  <td class=xl6921287>:</td>
  <td colspan=13 class=xl15921287 style='border-right:.5pt solid black'><?php echo "$tgl_pemeriksaan"; ?></td>
  <td colspan=9 class=xl12121287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>2 : Di bawah rata-rata</td>
  <td colspan=4 class=xl11321287 style='border-right:2.0pt double black;
  border-left:none'>70 – 85</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=10 class=xl18121287 style='height:10.0pt'><span
  style='mso-spacerun: yes; font-size: 9pt;'> </span>Tujuan Pemeriksaan</td>
  <td class=xl7421287>:</td>
  <td colspan=13 class=xl16121287 style='border-right:.5pt solid black'><?php echo "$tujuan_pemeriksaan"; ?></td>
  <td colspan=9 class=xl14521287 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>1 : Jauh di bawah rata-rata</td>
  <td colspan=4 class=xl14921287 style='border-right:2.0pt double black;
  border-left:none'>&lt;70</td>
 </tr>
 <tr height=5 style='mso-height-source:userset;height:15.0pt'>
  <td height=10 class=xl6521287 style='height:0.2pt'></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6921287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6521287></td>
  <td class=xl6621287></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td colspan=12 rowspan=2 height=15 class=xl18321287 style='border-bottom: 2.0pt double black; height: 14.45pt; font-size: 10pt;'>ASPEK PSIKOLOGIS</td>
  <td colspan=18 rowspan=2 class=xl16321287 style='border-right: .5pt solid black; border-bottom: 2.0pt double black; font-size: 10pt;'>KETERANGAN</td>
  <td colspan=7 class=xl14621287 style='border-right: 2.0pt double black; border-left: none; font-size: 9pt;'>PENILAIAN</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=10 class=xl7321287 style='height: 9.95pt; border-left: none; font-size: 9pt;'>1</td>
  <td class=xl7321287 style='border-left: none; font-size: 9pt;'>2</td>
  <td class=xl7321287 style='border-left: none; font-size: 9pt;'>3</td>
  <td class=xl7221287 style='border-left: none; font-size: 9pt;'>4</td>
  <td class=xl7321287 style='border-left: none; font-size: 9pt;'>5</td>
  <td class=xl7321287 style='border-left: none; font-size: 9pt;'>6</td>
  <td class=xl7921287 style='border-left: none; font-size: 9pt;'>7</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=15 class=xl18521287 style='height:15.9pt'>A</td>
   <td colspan=10 class=xl15121287 style='border-bottom:.5pt solid black'>ASPEK
     INTELEKTUAL</td>
   <td height="17" colspan=25 class=xl15121287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10.9pt'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>1</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Inteligensi
     Umum</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Gabungan keseluruhan potensi
     kecerdasan sebagai perpaduan dari aspek-aspek pembentukan intelektualitas.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a1==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>2</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Pengetahuan
     Umum</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Keluasan<span
  style='mso-spacerun:yes'>  </span>pengetahuan dan informasi yang menunjang
     kemampuannya memecahkan masalah.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a2==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
  </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>3</td>
   <td colspan=9 class=xl10921287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Daya Analisa Sintesa</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kemampuan membedakan hal-hal
     penting dan kurang penting sehingga mampu menguraikan masalah secara
     mendalam.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a3==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>4</td>
   <td colspan=9 class=xl10921287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Penalaran Verbal</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kemampuan memahami dan
     mengungkapkan pikiran dengan menggunakan kalimat verbal</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a4==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>5</td>
   <td colspan=9 class=xl10921287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Orientasi Pandang Ruang</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kemampuan memahami konsep-konsep
     jarak, arah dan ruang tiga dimensi.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a5==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>6</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Kemampuan
     Numerik</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kemampuan memahami dan
     mengungkapkan pikiran dengan menggunakan simbol angka dan grafik</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'>
     <?php
  if ($a6==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='border-bottom:2.0pt double black;
  height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:2.0pt double black'>7</td>
   <td colspan=9 class=xl10921287 style='border-bottom:2.0pt double black'>Klasifikasi
     dan Diferensiasi</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:2.0pt double black;width:252pt'>Kemampuan untuk melakukan
     pengelompokan dan pembedaan data secara tekun dan teliti</td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:2.0pt double black'>
     <?php
  if ($a7==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=14 class=xl18521287 style='height:15.9pt'>B</td>
   <td colspan=10 class=xl15121287 style='border-bottom:.5pt solid black'>ASPEK
     SIKAP KERJA</td>
   <td height="17" colspan=25 class=xl15121287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>1</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Kecepatan
     Kerja</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kecepatan dan kecekatan kerja,
     menunjukan kemampuan menyelesaikan sejumlah tugas dalam batas waktu tertentu</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b1==1){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b1==2){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b1==3){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'><?php
  if ($b1==4){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b1==5){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b1==6){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'><?php
  if ($b1==7){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>2</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Ketelitian
     Kerja</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Kemampuan untuk bekerja dengan
     sesedikit mungkin melakukan kesalahan/kekeliruan</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b2==1){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b2==2){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b2==3){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'><?php
  if ($b2==4){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b2==5){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($b2==6){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'><?php
  if ($b2==7){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='border-bottom:2.0pt double black;
  height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:2.0pt double black'>3</td>
   <td colspan=9 class=xl10921287 style='border-bottom:2.0pt double black'>Konsentrasi</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:2.0pt double black;width:252pt'>Kemampuan untuk mempertahankan
     perhatian dan fokus terhadap pelaksanaan tugas<span
  style='mso-spacerun:yes'> </span></td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:2.0pt double black'>
     <?php
  if ($b3==7){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=15 class=xl18521287 style='height:10.9pt'>C</td>
   <td colspan=12 class=xl15121287 style='border-bottom:.5pt solid black'>ASPEK
     KEPRIBADIAN</td>
   <td height="17" colspan=23 class=xl14121287 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>1</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Stabilitas
     Emosi</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Menunjukkan kematangan pribadi,
     mampu mengendalikan emosi,<span style='mso-spacerun:yes'>  </span>serta mampu
     menyesuaikan emosi dengan situasi.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c1==1){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c1==2){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c1==3){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'><?php
  if ($c1==4){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c1==5){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c1==6){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'><?php
  if ($c1==7){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:.5pt solid black'>2</td>
   <td colspan=9 class=xl10921287 style='border-bottom:.5pt solid black'>Penyesuaian
     Diri</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:252pt'>Mampu menyesuaikan diri dengan
     perbagai situasi,<span style='mso-spacerun:yes'>  </span>berbagai tugas,
     tanggung jawab dan orang-orang disekitarnya.</td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c2==1){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c2==2){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c2==3){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl9521287 style='border-bottom:.5pt solid black'><?php
  if ($c2==4){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c2==5){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl11121287 style='border-bottom:.5pt solid black'><?php
  if ($c2==6){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
   <td class=xl10221287 style='border-bottom:.5pt solid black'><?php
  if ($c2==7){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
   <td colspan=2 height=10 class=xl10421287 style='border-bottom:2.0pt double black;
  height:10'>&nbsp;</td>
   <td class=xl10721287 style='border-bottom:2.0pt double black'>3</td>
   <td colspan=9 class=xl10921287 style='border-bottom:2.0pt double black'>Hubungan
     Interpersonal</td>
   <td colspan=18 class=xl15321287 width=703 style='border-right:.5pt solid black;
  border-bottom:2.0pt double black;width:252pt'>Kemampuan menghadapi bermacam
     macam orang secara efektif dalam berbagai situasi.</td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==1){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==2){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==3){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl9521287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==4){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==5){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl11121287 style='border-bottom:2.0pt double black'>
     <?php
  if ($c3==6){
	echo "X";
  }else {
		echo "";
	}
  ?>
     </td>
   <td class=xl10221287 style='border-bottom:2.0pt double black'><?php
  if ($c3==7){
	echo "X";
  }else {
		echo "";
	}
  ?></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
   <td height=20 class=xl6721287 style='height:5.0pt'></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6821287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6721287></td>
   <td class=xl6521287></td>
   <td class=xl6521287></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=28 rowspan=2 height=20 class=xl17521287 width=703
  style='border-right:2.0pt double black;height:20.0pt;width:392pt'>KETERANGAN
  IQ</td>
  <td class=xl6521287></td>
  <td colspan=8 rowspan=2 class=xl20021287 style='border-right:2.0pt double black;
  border-bottom:.5pt solid black'>ARAH MINAT</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6521287 style='height:15.0pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td rowspan=2 height=10 class=xl18621287 width=703 style='height:10.0pt;
  border-top:none;width:11pt'>l</td>
  <td colspan=27 rowspan=2 class=xl17321287 width=703 style='border-right: 2.0pt double black; width: 378pt; font-size: 9pt;'>Kecerdasan umum Sdr/i, DWI NATASARI JUWITA<span
  style='mso-spacerun:yes'>  </span>diperkirakan berfungsi pada taraf
  Rata-rata, dengan IQ 100 (dalam kisaran 95 - 105) berdasarkan skala CFIT.</td>
  <td class=xl6521287></td>
  <td colspan=8 rowspan=3 class=xl19121287 style='border-right:2.0pt double black;
  border-bottom:2.0pt double black'><?php echo "$arah_minat"; ?></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6521287 style='height:15.0pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td rowspan=2 height=10 class=xl8421287 style='height:10.0pt'>l</td>
  <td colspan=27 rowspan=2 class=xl17121287 width=703 style='border-right: 2.0pt double black; width: 378pt; font-size: 9pt;'>Dengan tingkat kecerdasannya tersebut diperkirakan ia akan
  kurang mampu mengikuti pendidikan pada jenjang Sekolah Lanjutan Tingkat Atas
  atau yang sederajat.</td>
  <td class=xl6521287></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7821287 style='height:15.0pt'></td>
  <td colspan=8 class=xl21321287>Jakarta, 21 April 2014</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td rowspan=2 height=10 class=xl8421287 style='height:10.0pt'>l</td>
  <td colspan=27 rowspan=2 class=xl17121287 width=703 style='border-right: 2.0pt double black; width: 378pt; font-size: 9pt;'>Selain itu, dengan melihat potensi akademisnya, diperkirakan ia
  akan dapat menunjukkan prestasi belajar yang optimal pada bidang-bidang IPS.</td>
  <td class=xl7121287></td>
  <td colspan=8 class=xl10021287>A.n. Psikolog Pemeriksa</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 style='height:15.0pt' align=left valign=top><!--[if gte vml 1]><v:shapetype
   id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
   path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="Picture_x0020_9" o:spid="_x0000_s1032" type="#_x0000_t75"
   alt="tanda tangan2" style='position:absolute;margin-left:3pt;margin-top:1.5pt;
   width:132.75pt;height:38.25pt;z-index:2;visibility:visible' o:gfxdata="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
bLcJfD2TUlRYzuPcmXsXy0G25CSMbbRi4E88IELlumhUxeCwf3mcA7GOq4K3WgkGn8LCMr29WfCk
0L3aiVPmKoIiyiacQe1cl1Bq81pIbie6EwpnpTaSOyxNRQvDexSXLQ08b0olbxReqHkn1rXIP7Kj
ZLAZ3pSMH3zfPq/942F7eM+GaM/Y/d2wegLixOCuyxf6tWAQhjM/nsLoB71Aik8O7UrltTak3Anb
fKGDn35ptCRG9wyiGZBctwyCGMbOpiytcLgXexGmgaPfTjj3PQ/oKOv0BUbmDIeY0184COdB9I+O
owD1kKbXr87FNcf0GwAA//8DAFBLAwQKAAAAAAAAACEAk0ZDW6chAACnIQAAFQAAAGRycy9tZWRp
YS9pbWFnZTEuanBlZ//Y/+AAEEpGSUYAAQEBANwA3AAA/9sAQwACAQECAQECAgICAgICAgMFAwMD
AwMGBAQDBQcGBwcHBgcHCAkLCQgICggHBwoNCgoLDAwMDAcJDg8NDA4LDAwM/9sAQwECAgIDAwMG
AwMGDAgHCAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM
/8AAEQgAdQGVAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQ
AAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYX
GBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqS
k5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz
9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQE
AAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1
Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKj
pKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwD
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
">
   <v:imagedata src="psikogram_files/psikogram_21287_image001.png" o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:2;margin-left:4px;margin-top:2px;width:177px;
  height:51px'><img width=177 height=51
  src="psikogram_files/psikogram_21287_image002.png" alt="tanda tangan2"
  v:shapes="Picture_x0020_9"></span><![endif]><span style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7721287 width=19 style='height:15.0pt;width:14pt'></td>
   </tr>
  </table>
  </span></td>
  <td colspan=8 class=xl7721287></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td rowspan=2 height=10 class=xl8421287 style='height:10.0pt'>l</td>
  <td colspan=27 rowspan=2 class=xl9321287 width=703 style='border-right: 2.0pt double black; width: 378pt; font-size: 9pt;'>Secara spesifik Sdr/i, DWI NATASARI JUWITA<span
  style='mso-spacerun:yes'>  </span>memiliki minat yang cukup menonjol pada
  bidang-bidang yang berhubungan dengan berikut ini, dengan presentase sebesar
  :</td>
  <td class=xl7721287></td>
  <td colspan=8 class=xl7721287></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7721287 style='height:15.0pt'></td>
  <td colspan=8 class=xl7721287></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=10 class=xl8421287 style='height:10.0pt'>&nbsp;</td>
  <td class=xl9121287>l</td>
  <td class=xl8621287 colspan=3>Realistic</td>
  <td class=xl8721287></td>
  <td colspan=3 class=xl9721287>18%</td>
  <td class=xl9121287></td>
  <td class=xl9121287>l</td>
  <td class=xl8721287 colspan=3>Artistic</td>
  <td colspan=3 class=xl9721287>100%</td>
  <td class=xl8721287></td>
  <td class=xl9121287>l</td>
  <td class=xl8721287 colspan=4>Enterprising</td>
  <td colspan=3 class=xl9721287>36%</td>
  <td class=xl8721287></td>
  <td class=xl8821287>&nbsp;</td>
  <td class=xl7721287></td>
  <td colspan=8 class=xl7121287>Drs. Budiman Sanusi Mpsi</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=10 class=xl8521287 style='height:10.0pt'>&nbsp;</td>
  <td class=xl9221287>l</td>
  <td class=xl8921287 colspan=4>Investigative</td>
  <td colspan=3 class=xl9821287>45%</td>
  <td class=xl9221287>&nbsp;</td>
  <td class=xl9221287>l</td>
  <td class=xl8921287 colspan=3>Social</td>
  <td colspan=3 class=xl9821287>64%</td>
  <td class=xl8921287>&nbsp;</td>
  <td class=xl9221287>l</td>
  <td class=xl8921287 colspan=4>Conventional</td>
  <td colspan=3 class=xl9821287>27%</td>
  <td class=xl8921287>&nbsp;</td>
  <td class=xl9021287>&nbsp;</td>
  <td class=xl7721287></td>
  <td colspan=8 class=xl10121287>No. HIMPSI: 0111891963</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
  <td width=703 style='width:14pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
