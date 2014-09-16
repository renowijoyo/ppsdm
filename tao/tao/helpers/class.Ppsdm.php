<?php

abstract class ppsdm_helpers {
    

	
    /**
     * Decode a binary string representing a file into an array.
     * 
     * The binary string that is decoded must respect the following scheme:
     * 
     * * filename length, unsigned short
     * * filename, string
     * * mimetype length, unsigned short
     * * mimetype, string
     * * binary content of the file, string
     * 
     * The returned array contains tree cells with the following keys:
     * 
     * * name, string (might be empty)
     * * mime, string
     * * data, string
     * 
     * @param string $binary A binary string representing the file to be decoded.
     * @return array The decoded file as an array.
     */

	
private $results_con;
private $rapordb_con;
private $tao_con;

public static function getTaoPassword($profile)
{
		//$psikotes_con = mysqli_connect(Config::RESULTS_DB_HOST, Config::RESULTS_DB_USER, Config::RESULTS_DB_PASS,Config::RESULTS_DB_NAME) or die("Unable to connect to MySQL");
		$ppsdm_con = mysqli_connect(Config::PPSDM_DB_HOST, Config::PPSDM_DB_USER, Config::PPSDM_DB_PASS,Config::PPSDM_DB_NAME) or die("Unable to connect to MySQL");
	//	$tao_con = mysqli_connect(Config::TAO_DB_HOST, Config::TAO_DB_USER, Config::TAO_DB_PASS,Config::TAO_DB_NAME) or die("Unable to connect to MySQL");

		$query = 'select password from user where username = "'. $profile . '";';
		$result = mysqli_query($ppsdm_con,$query);		
		$tao_password_result_temp = mysqli_fetch_array($result);
		$tao_password_result = $tao_password_result_temp['password'];

				mysqli_close($ppsdm_con);
				//return 'reno';
				return $tao_password_result;
}
	

public static function finishTest($deliveryExecution)
	{

		$result_con = mysqli_connect(Config::RESULTS_DB_HOST, Config::RESULTS_DB_USER, Config::RESULTS_DB_PASS,Config::RESULTS_DB_NAME) or die("Unable to connect to MySQL");
		$rapordb_con = mysqli_connect(Config::PPSDM_DB_HOST, Config::PPSDM_DB_USER, Config::PPSDM_DB_PASS,Config::PPSDM_DB_NAME) or die("Unable to connect to MySQL");
		$tao_con = mysqli_connect(Config::TAO_DB_HOST, Config::TAO_DB_USER, Config::TAO_DB_PASS,Config::TAO_DB_NAME) or die("Unable to connect to MySQL");
		

	

		$compiledDelivery = $deliveryExecution->getDelivery();
		
		$tao_delivery = $compiledDelivery->getUri();
		$tao_subject =  common_session_SessionManager::getSession()->getUserUri();
		$username =  common_session_SessionManager::getSession()->getUserLabel();
		//Alternative method ==> $tao_subject = $deliveryExecution->getUserIdentifier();
		$tao_delivery_label = $compiledDelivery->getLabel(); 
			$tao_delivery_execution = $deliveryExecution->getIdentifier();
			
		$delivery_result_sql = 'select subject from statements where object = "'. $tao_delivery_execution . '" AND predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#Identifier";';
		$delivery_result_result = mysqli_query($tao_con,$delivery_result_sql);		
		$tao_delivery_result_temp = mysqli_fetch_array($delivery_result_result);
		$tao_delivery_result = $tao_delivery_result_temp['subject'];
		
		$eportfolio_template_uri_temp = explode("::", $tao_delivery_label);
		$eportfolio_template_uri = $eportfolio_template_uri_temp[0];
		
		//////////////////////DARI SINI////////////////////////////////////
		$eportfolio_template_id_sql = 'select id from eportfolio_template where uri="'.$eportfolio_template_uri.'" order by id desc limit 1';
		$eportfolio_template_id_result = mysqli_query($rapordb_con, $eportfolio_template_id_sql);
		$eportfolio_template_id_temp = mysqli_fetch_array($eportfolio_template_id_result);
		$eportfolio_template_id = $eportfolio_template_id_temp['id'];
		
		
		$get_profile_id_sql = 'select id from profile where user_id in (select id from user where username = "'.$username.'"order by id desc)';
		$get_profile_id_result = mysqli_query($rapordb_con, $get_profile_id_sql);
		$get_profile_id_temp = mysqli_fetch_array($get_profile_id_result );
		$profile_id = $get_profile_id_temp['id'];
		
		$eportfolio_id_sql = 'select id from eportfolio where eportfolio_template_id = "'.$eportfolio_template_id.'" AND profile_id="'.$profile_id.'" order by id desc limit 1';
		$eportfolio_id_result = mysqli_query($rapordb_con, $eportfolio_id_sql);
		$eportfolio_id_temp = mysqli_fetch_array($eportfolio_id_result );
		$eportfolio_id = $eportfolio_id_temp['id'];

		$rapor_item_template_id_sql = 'select id from item_template where uri ="'.$tao_delivery_label.'" order by id desc limit 1';
		$rapor_item_template_id_result = mysqli_query($rapordb_con, $rapor_item_template_id_sql);
		if(empty($rapor_item_template_id_result))
		{
				$rapor_item_template_id = 'NULL';
		} else {
		$rapor_item_template_id_temp = mysqli_fetch_array($rapor_item_template_id_result);
		$rapor_item_template_id = $rapor_item_template_id_temp['id'];
		}

		
		
		$item_id_sql = 'select id from item where item_template_id = "'.$rapor_item_template_id.'" AND eportfolio_id="'.$eportfolio_id.'" order by id desc limit 1';
		$item_id_result = mysqli_query($rapordb_con, $item_id_sql);
		$item_id_temp = mysqli_fetch_array($item_id_result );
		$item_id = $item_id_temp['id'];
	
	//////////////////////////SAMPAI SINI HARUSNYA BISA DIBUAT SATU QUERY////////////////////////////////////

	
		$tao_result_json = array();
		$tao_score_array = array();
		$tao_item_array = array();
		$tao_score_string = '';
		
		
		$returnedResultsData = self::getResults($tao_delivery_result,$tao_con);
		while ($row = mysqli_fetch_array($returnedResultsData))
		{
			if (isset($row['itemPropertyName'])) {
			$tao_result_json[$row['itemId']][$row['itemPropertyName']]=$row['itemPropertyValue'];
			if ($row['itemPropertyName'] == 'SCORE')
				array_push($tao_score_array,array($row['itemId']=>base64_decode($row['itemPropertyValue'])));
			}
		}
		
		$result_json = json_encode($tao_result_json);
		$scores_string = json_encode($tao_score_array);
		
		$insert_result_sql = "insert into results (rapor_item_id,last_modified,tao_delivery, tao_delivery_execution,tao_delivery_result,tao_delivery_label, tao_subject,result_json,scores_string)
		values(".$item_id.",CURRENT_TIMESTAMP,'".$tao_delivery."','".$tao_delivery_execution."','".$tao_delivery_result."','".$tao_delivery_label."','".$tao_subject."','".addslashes($result_json)."','".addslashes($scores_string)."')";
		$result_result = mysqli_query($result_con, $insert_result_sql);
		
		mysqli_close($result_con);
		mysqli_close($rapordb_con);
		mysqli_close($tao_con);
		return;
	}
	
	public static function getResults($tao_delivery_result, $tao_con)
	{
	

		$sql = 'SELECT T1.subject AS "itemId", T1.object AS "itemName",  T2.subject  AS "itemPropertyUri" , T3.object AS "itemPropertyName" , T4.object AS "itemPropertyValue" FROM ('.
		'SELECT * FROM statements AS s0 WHERE subject IN ('.
		'(SELECT subject FROM statements WHERE predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#relatedDeliveryResult" AND object = "'.$tao_delivery_result.'")) AND predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#Identifier" order by id) AS T1 ' . 
		'LEFT OUTER JOIN (SELECT s1.subject, s1.predicate, s1.object FROM statements AS s1 WHERE s1.predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#relatedItemResult") AS T2 on T1.subject = T2.object ' . 
		'LEFT OUTER JOIN (SELECT s2.subject, s2.predicate, s2.object FROM statements AS s2 WHERE s2.predicate = "http://www.tao.lu/Ontologies/TAOResult.rdf#Identifier") AS T3 on T2.subject = T3.subject ' . 
		'LEFT OUTER JOIN (SELECT s3.subject, s3.predicate, s3.object FROM statements AS s3 WHERE s3.predicate = "http://www.w3.org/1999/02/22-rdf-syntax-ns#value") AS T4 on T4.subject = T3.subject';
		
		$result = mysqli_query($tao_con,$sql);
		return $result;

	
	}
	
	

}


?>