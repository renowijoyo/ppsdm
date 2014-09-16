<?php
ini_set('display_errors', '0'); 
require_once('Config.php');
class TaoHelper
{

private $results_con;
private $ppsdm_con;
private $tao_con;

public function __construct()
{
		$this->results_con = mysqli_connect(Config::RESULTS_DB_HOST, Config::RESULTS_DB_USER, Config::RESULTS_DB_PASS,Config::RESULTS_DB_NAME) or die("Unable to connect to MySQL");
		$this->ppsdm_con = mysqli_connect(Config::PPSDM_DB_HOST, Config::PPSDM_DB_USER, Config::PPSDM_DB_PASS,Config::PPSDM_DB_NAME) or die("Unable to connect to MySQL");
		$this->tao_con = mysqli_connect(Config::TAO_DB_HOST, Config::TAO_DB_USER, Config::TAO_DB_PASS,Config::TAO_DB_NAME) or die("Unable to connect to MySQL");
}

public function dbClose()
{
		mysqli_close($this->results_con);
		mysqli_close($this->ppsdm_con);
		mysqli_close($this->tao_con);	
}		

public function test($value)
{

		$sql = "insert into results (tao_delivery_result) VALUES ('".$value."');";
		$result = mysqli_query($this->results_con,$sql);
		$row = mysqli_fetch_array($result);
		return;
}
public function newTesttaker($username, $password, $groupname) 
	{
		$rest_uri_string  = Config::TAO_HOST . Config::TAO_ROOT . '/taoSubjects/RestSubjects';	
		$testtakergroup_temp= $this->getTesttakerGroupUri($groupname);
		$testtakergroup = $testtakergroup_temp['subject'];
		$process = curl_init($rest_uri_string);
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_POSTFIELDS, "");
		curl_setopt($process,CURLOPT_HTTPHEADER, array(
			"Accept: application/json",
			"label: ".$username,
			"login: ".$username,
			"password: ".$password,
			"type: ".$testtakergroup,
		));

		curl_setopt($process, CURLOPT_USERPWD, "admin:admin");
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		$returnedData = curl_exec($process);
		//allways check the http code returned
		$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
		$data = json_decode($returnedData, true);
		curl_close($process);
		echo $rest_uri_string . '<br/>';
		echo $httpCode;
	}
	
	
	public function getProfileUri($profilename)
	{
		$sql = "select subject from statements where predicate = 'http://www.tao.lu/Ontologies/generis.rdf#login' and object = '".$profilename."' order by id desc limit 1";
		$result = mysqli_query($this->tao_con,$sql);
		$row = mysqli_fetch_array($result);
		return $row['subject'];
	}
	public function getTesttakerGroupUri($groupname)
	{
		$sql = 'select * from statements where object = "'.$groupname.'" and predicate = "http://www.w3.org/2000/01/rdf-schema#label"';
		$result = mysqli_query($this->tao_con,$sql);
		$row = mysqli_fetch_array($result);
		return $row;
	}
	public function getGroupUri($groupname) //group name have prepended by GROUP_
	{

/*
	$sql = 'select * from (select subject from statements where object = "'.$groupname.'" and predicate = "http://www.w3.org/2000/01/rdf-schema#label") as tabel1
			INNER JOIN 
			statements
			as tabel2 
			on tabel1.subject = tabel2.subject
			WHERE predicate="http://www.w3.org/1999/02/22-rdf-syntax-ns#type"';
*/

			$subgroups = explode('/',$groupname);
		$subgroup_size = sizeof($subgroups);
	//echo $subgroup_size;
	
	$sql = 'SELECT
	SUBJECT 
FROM
	statements
WHERE
	SUBJECT IN (
		SELECT
			SUBJECT
		FROM
			statements
		WHERE
			object IN (
			
				SELECT
					SUBJECT 
				FROM
					statements
				WHERE
					SUBJECT IN (
						SELECT
							SUBJECT
						FROM
							statements
						WHERE
							object IN (
						
								SELECT
									SUBJECT 
								FROM
									statements
								WHERE
									SUBJECT IN (
										SELECT
											SUBJECT
										FROM
											statements
										WHERE
											predicate = "http://www.w3.org/2000/01/rdf-schema#subClassOf"
										AND object = "http://www.tao.lu/Ontologies/TAOGroup.rdf#Group"
									)
								AND predicate = "http://www.w3.org/2000/01/rdf-schema#label"
								AND object = "'.$subgroups[0].'" #==========================================================
							)
						AND predicate = "http://www.w3.org/2000/01/rdf-schema#subClassOf"
					)
				AND predicate = "http://www.w3.org/2000/01/rdf-schema#label"
				AND object = "'.$subgroups[1].'" #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			)
		AND predicate = "http://www.w3.org/1999/02/22-rdf-syntax-ns#type"
	)
AND object = "'.$subgroups[2].'"';

		$result = mysqli_query($this->tao_con,$sql);
		$row = mysqli_fetch_array($result);
		return $row;

	}
	
	
	
	
	public function getGroupMembers($groupuri)
	{

		$sql ='select object from statements where subject ="'.$groupuri.'" and predicate ="http://www.tao.lu/Ontologies/TAOGroup.rdf#Members"';
		$result = mysqli_query($this->tao_con,$sql);
		$members = '';
		
		while ($row = mysqli_fetch_array($result))
		{
			$members = $members . ','.$row['object']; 
			
		}
		return $members;
	}
	
	public function getTaoModeluri($id)
	{
		$sql ='select modeluri from models where modelid="'.$id.'"';
		$result = mysqli_query($this->tao_con,$sql);
		$row = mysqli_fetch_array($result);
		return $row['modeluri'];
	
	}
	
	
	public function alreadyMember($groupuri,$nameuri)
	{
		$sql ='select * from statements where subject ="'.$groupuri.'" and predicate ="http://www.tao.lu/Ontologies/TAOGroup.rdf#Members" and object="'.$nameuri.'" order by id desc';
		$result = mysqli_query($this->tao_con,$sql);
		$row = mysqli_fetch_array($result);
		return $row;
	}
	
	public function groupSignup($username, $group)
	{
		$groupuri_temp = $this->getGroupUri($group);
	$groupuri = $groupuri_temp['SUBJECT'];
	$nameuri = $this->getProfileUri($username);
	$modelid = '1';
	$modeluri = $this->getTaoModelUri($modelid);
	echo 'yang didadftarkan adalah group : ' .$groupuri . ' dengan member : ' . $nameuri. '<br/>';
	if ( isset($nameuri) && isset($groupuri) && is_null($this->alreadyMember($groupuri,$nameuri))) {
								$row = array();
								$row['modelid'] = $modelid;
								$row['subject'] = $groupuri;
								$row['predicate'] = "http://www.tao.lu/Ontologies/TAOGroup.rdf#Members";
								$row['object'] = $nameuri;
								$row['author'] = $modeluri.'superUser';
								
								$sqlinsert = 'insert into statements (modelid,subject,predicate,object,l_language,author,epoch) values (
										"'.$row["modelid"].'",
								"'.$row["subject"].'",
								"'.$row["predicate"].'",
								"'.$row["object"].'",
								"",
								"'.$row["author"].'",
								CURRENT_TIMESTAMP	
								)';
						$insertresult = mysqli_query($this->tao_con,$sqlinsert);
					
				//	echo 'anda belum terdaftar';
	} else {
	
						echo 'Anda sudah terdaftar sebelumnya ATAU ADA YANG SALAH<br/>';
					//echo 'bayar';
					echo '<a href="'.$_SERVER["HTTP_REFERER"].'"><button>Lanjut</button></a>';
	}
	
	}
	
	public function addGroupMember($profilename, $group) //UNTUK PENAMBAHAN TESTTAKER KE GROUP DILAKUKAN MELALUI 2 METODE: menggunakan REST dan langsung ke Database
	{
	//	$rest_uri_string  = Config::TAO_HOST . Config::TAO_ROOT . '/taoGroups/RestGroups';
	//	$process = curl_init($rest_uri_string);
		//curl_setopt($process, CURLOPT_PUT, 1);
	//	curl_setopt($process, CURLOPT_POSTFIELDS, "");
			$groupname = 'GROUP_' . $group;
	//	echo '<br/>group name : ' . $groupname;
		$groupuri_temp= $this->getGroupUri($groupname);
		
		$groupuri = $groupuri_temp['subject'];
		$grouptype = $groupuri_tempp['object'];

		$nameuri = $this->getProfileUri($profilename);
		
		// MUST CHECK FIRST IF NAMEURI ALREADY EXIST!!
		if (is_null($this->alreadyMember($groupuri,$nameuri))) {
		
/*
						if ($grouptype == "http://www.tao.lu/Ontologies/TAOGroup.rdf#Group"){
						 REST METHOD TO MEMBER TO GROUP
									$members = $this->getGroupMembers($groupuri);
									$members = $members . ',' . $nameuri;

									curl_setopt($process,CURLOPT_HTTPHEADER, array(
									"Accept: application/xml",
									"uri : ". $groupuri,
									"member: ". substr($members,1)
									));
									curl_setopt($process, CURLOPT_USERPWD, Config::TAO_ADMIN_USER . ":" . Config::TAO_ADMIN_PASS);
									//return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
									curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
									$returnedData = curl_exec($process);
									$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
									

						} else {
					*/
								$row = array();
								$row['modelid'] = '1';
								$row['subject'] = $groupuri;
								$row['predicate'] = "http://www.tao.lu/Ontologies/TAOGroup.rdf#Members";
								$row['object'] = $nameuri;
								$row['author'] = Config::TAO_HOST . '/'.'ppsdm.rdf#superUser';
								
								$sqlinsert = 'insert into statements (modelid,subject,predicate,object,l_language,author,epoch) values (
										"'.$row["modelid"].'",
								"'.$row["subject"].'",
								"'.$row["predicate"].'",
								"'.$row["object"].'",
								"",
								"'.$row["author"].'",
								CURRENT_TIMESTAMP	
								)';
						$insertresult = mysqli_query($this->tao_con,$sqlinsert);
						//}
							echo 'Apakah anda ingin mengambil asesmen ini?<br/>';
							
							echo '<a href="'.$_SERVER["HTTP_REFERER"].'"><button>Bayar</button></a>';
				} else {
					echo 'Anda sudah terdaftar sebelumnya<br/>';
					//echo 'bayar';
					echo '<a href="'.$_SERVER["HTTP_REFERER"].'"><button>Lanjut</button></a>';
				}		
				curl_close($process);	

	}
	

	
	public function getResults($tao_delivery_result)
	{
	

		$sql = 'SELECT T1.subject AS "itemId", T1.object AS "itemName",  T2.subject  AS "itemPropertyUri" , T3.object AS "itemPropertyName" , T4.object AS "itemPropertyValue" FROM ('.
		'SELECT * FROM statements AS s0 WHERE subject IN ('.
		'(SELECT subject FROM statements WHERE predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#relatedDeliveryResult" AND object = "'.$tao_delivery_result.'")) AND predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#Identifier" order by id) AS T1 ' . 
		'LEFT OUTER JOIN (SELECT s1.subject, s1.predicate, s1.object FROM statements AS s1 WHERE s1.predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#relatedItemResult") AS T2 on T1.subject = T2.object ' . 
		'LEFT OUTER JOIN (SELECT s2.subject, s2.predicate, s2.object FROM statements AS s2 WHERE s2.predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#Identifier") AS T3 on T2.subject = T3.subject ' . 
		'LEFT OUTER JOIN (SELECT s3.subject, s3.predicate, s3.object FROM statements AS s3 WHERE s3.predicate = "http://www.w3.org/1999/02/22-rdf-syntax-ns#value") AS T4 on T4.subject = T3.subject';
		
		$result = mysqli_query($this->tao_con,$sql);

		return $result;

	
	}

	
	public function finishAssessment($delivery_object)
	{
	
		$item_index = 0;
		$tao_result_json = array();
		$tao_score_array = array();
		$tao_item_array = array();
		$tao_score_string = '';
		$returnedResultsData = $this->getResults($delivery_object['tao_delivery_result']);
		
		while ($row = mysqli_fetch_array($returnedResultsData))
		{
			//array_push($tao_result_json,array($row['itemId'], array($row['itemPropertyName']=>$row['itemPropertyValue'])));
			//array_push($tao_result_json[$row['itemId']],array($row['itemPropertyName']=>$row['itemPropertyValue']));

			if (isset($row['itemPropertyName'])) {
			$tao_result_json[$row['itemId']][$row['itemPropertyName']]=$row['itemPropertyValue'];
			if ($row['itemPropertyName'] == 'SCORE')
				array_push($tao_score_array,array($row['itemId']=>base64_decode($row['itemPropertyValue'])));
			}
		}

		
		$this->insertToResultsDB($tao_result_json,$tao_score_array,$delivery_object);
		$this->insertToAssessment($delivery_object);
		$this->updateTaoResultGroup($delivery_object); //NOT INSERT BUT MODIFY DATA - change result group
		

		
		
	}
	
	public function updateTaoResultGroup($delivery_object)
	{
	$result_group_name = 'RESULT_' . $delivery_object['group'];
		$groupuri = $this->getResultGroupUri($result_group_name);
		$query = 'UPDATE statements SET object="'.$groupuri.'" where subject="'.$delivery_object['tao_delivery_result'].'" and predicate="http://www.w3.org/1999/02/22-rdf-syntax-ns#type"';
		$result = mysqli_query($this->tao_con,$query);
		return $result;
	
	}

	public function insertToResultsDB($tao_result_json, $tao_score_array,$delivery_object)
	{
		$json_result = json_encode($tao_result_json);
		$json_score = json_encode($tao_score_array);

		$query = "insert into results (
											tao_delivery_result,
											tao_delivery_execution,
											tao_delivery,
											tao_delivery_label,
											tao_subject,
											
											ppsdm_profile,
											ppsdm_assessment_id,
											result_json,
											scores_string,
											status,
											last_modified
												) VALUES 
											(
											'".$delivery_object['tao_delivery_result']."',
												'".$delivery_object['tao_delivery_execution']."',			
											'".$delivery_object['tao_delivery']."',
											'".$delivery_object['tao_delivery_label']."',			
											'".$delivery_object['tao_subject']."',
											
													
											'".$delivery_object['ppsdm_profile']."',
											'".$delivery_object['ppsdm_assessment_id']."',
											'".addslashes($json_result) ."',
											'".addslashes($json_score) ."',
											'".$delivery_object['status']."',
												CURRENT_TIMESTAMP);";
												
											//	$query = "insert into results (tao_delivery_result) VALUES('1')";
									
		$result = mysqli_query($this->results_con,$query);
		return $result;
	}

	
public function insertToAssessment($delivery_object)
	{
			$query_get_profile = 'select id from profile where user_id in (select id from user where username = "'.$delivery_object['ppsdm_profile'].'")';
		$result_2= mysqli_query($this->ppsdm_con,$query_get_profile);
		$ppsdm_profile_id = mysqli_fetch_array($result_2);
		$result_url = $delivery_object['result_url'];
	
		$query2 = "insert into assessment (profile_id,tao_subject,assessment_item_id,tao_test,tao_test_label,tao_delivery_label,tao_delivery_result,tao_delivery_status,finish_time,note,result_url,download_url) " .
				" VALUES (".
		"'".$ppsdm_profile_id[0]."','".$delivery_object['tao_subject']."','".$delivery_object['ppsdm_assessment_id']."','".$delivery_object['tao_test']."','".$delivery_object['tao_test_label']."','".$delivery_object['tao_delivery_label'].
		"','".$delivery_object['tao_delivery_result']."','completed','".date('Y-m-d h:i:s')."','prepaid','".$delivery_object['result_url']."','".substr($result_url,0,strrpos($result_url,'.'))."_download.php');";
		
		//$query2 = "insert into assessment (tao_subject) VALUES ('".$ppsdm_profile_id[0]."');";
		
		$result = mysqli_query($this->ppsdm_con,$query2);

		return $result;
	}	
	
	public function getResultGroupUri($groupname)
	{
		$sql = 'select id,subject from statements where object = "'.$groupname.'" and predicate = "http://www.w3.org/2000/01/rdf-schema#label" order by id desc';
		$result= mysqli_query($this->tao_con,$sql);
		$groupuri= mysqli_fetch_array($result);
		$groupnameuri = $groupuri['subject'];
		if (isset($groupnameuri))
		{
			return $groupnameuri;
		} else {
			return "http://www.tao.lu/Ontologies/TAOResult.rdf#DeliveryResult";
		}

	}
	
}
							
							
							?>
