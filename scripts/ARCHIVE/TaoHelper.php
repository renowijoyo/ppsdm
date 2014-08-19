<?php
ini_set('display_errors', '0'); 

class TaoHelper
{

const DB_USER = "ppsdm";
const DB_PASSWORD = "ppsdM2014";
const DB_HOST = "localhost";
const DB_NAME = "tao_db";
const TAO_HOST = "http://tao.ppsdm.com/";
const TAO_ROOT = "tao";

	public function new_testtaker($usermodel) {

	
		//$process = curl_init("http://127.0.0.1/taoplatform/taoSubjects/RestSubjects");
				$rest_uri_string  = self::TAO_HOST . self::TAO_ROOT . '/taoSubjects/RestSubjects';
		$process = curl_init($rest_uri_string);
		curl_setopt($process, CURLOPT_POST, 1);

		//needed using curl on apache
		curl_setopt($process, CURLOPT_POSTFIELDS, "");

		curl_setopt($process,CURLOPT_HTTPHEADER, array(
		"Accept: application/json",
		"label: ".$usermodel->username,
		"login: ".$usermodel->username,
		"password: ".$usermodel->password,
		));

		//set your credentials
		curl_setopt($process, CURLOPT_USERPWD, "admin:admin");

		//return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

		$returnedData = curl_exec($process);

		//allways check the http code returned
		$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);

		$data = json_decode($returnedData, true);

		curl_close($process);
	}
	
	
	public function get_profile_uri($profilename)
	{
			$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
		$sql = "select subject from statements where predicate = 'http://www.tao.lu/Ontologies/generis.rdf#login' and object = '".$profilename."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		mysqli_close($con);
		return $row['subject'];
	}
	public function user_already_exist($profilename)
	{
		$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
		$sql = "select subject from statements where predicate = 'http://www.tao.lu/Ontologies/generis.rdf#login' and object = '".$profilename."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		mysqli_close($con);
		return $row['subject'];
	}
	public function get_group_uri($groupname) //group name have prepended by GROUP_
	{
	
		$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
	$sql = 'select * from (select subject from statements where object = "'.$groupname.'" and predicate = "http://www.w3.org/2000/01/rdf-schema#label") as tabel1
INNER JOIN 
statements
as tabel2 
on tabel1.subject = tabel2.subject
WHERE predicate="http://www.w3.org/1999/02/22-rdf-syntax-ns#type"';


		$result = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($result);
		mysqli_close($con);

		return $row;

	}
	
	public function get_groups()
	{
	
		//$process = curl_init("http://127.0.0.1/taoplatform/taoGroups/RestGroups");
		$rest_uri_string  = self::TAO_HOST . self::TAO_ROOT . '/taoGroups/RestGroups';
		$process = curl_init($rest_uri_string);
		curl_setopt($process, CURLOPT_HTTPGET, 1);
		curl_setopt($process,CURLOPT_HTTPHEADER, array(
		"Accept: application/xml"
		));
		curl_setopt($process, CURLOPT_USERPWD, "admin:admin");
		//return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		$returnedData = curl_exec($process);
		$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);

		curl_close($process);

		echo $returnedData;
	}
	
	
	public function get_group_members($groupuri)
	{
//echo 'saa';
		$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
		
		

		$sql ='select object from statements where subject ="'.$groupuri.'" and predicate ="http://www.tao.lu/Ontologies/TAOGroup.rdf#Members"';
		$result = mysqli_query($con,$sql);
		$members = '';
		
		while ($row = mysqli_fetch_array($result))
		{
			$members = $members . ','.$row['object']; 
			
		}
		mysqli_close($con);
		//$str2 = substr($str, 4)
		return $members;
		
		
	
	}
	
	public function alreadyMember($groupuri,$nameuri)
	{
		$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
		$sql ='select * from statements where subject ="'.$groupuri.'" and predicate ="http://www.tao.lu/Ontologies/TAOGroup.rdf#Members" and object="'.$nameuri.'"';
		$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result);

		mysqli_close($con);
	
		return $row;
	
	}
	
	
	
	public function add_group_member($profilename, $groupname) //UNTUK PENAMBAHAN TESTTAKER KE GROUP DILAKUKAN MELALUI 2 METODE: menggunakan REST dan langsung ke Database
	{
		

		$rest_uri_string  = self::TAO_HOST . self::TAO_ROOT . '/taoGroups/RestGroups';
		$process = curl_init($rest_uri_string);
		curl_setopt($process, CURLOPT_PUT, 1);
	
		//curl_setopt($process, CURLOPT_CUSTOMREQUEST, "UPDATE");
		curl_setopt($process, CURLOPT_POSTFIELDS, "");
			
		$groupuri_temp= self::get_group_uri($groupname);	// ONLY CONTINUE IF NOT NULL/EMPTY
		$groupuri = $groupuri_temp['subject'];
		$grouptype = $groupuri_temp['object'];

		$nameuri = self::get_profile_uri($profilename); // ONLY CONTINUE IF NOT NULL/EMPTY
		
		// MUST CHECK FIRST IF NAMEURI ALREADY EXIST!!
		if (is_null(self::alreadyMember($groupuri,$nameuri)) && !is_null($groupuri) && !is_null($nameuri)) {
				if ($grouptype == "http://www.tao.lu/Ontologies/TAOGroup.rdf#Group"){
				//echo '1';
					$members = self::get_group_members($groupuri);
					$members = $members . ',' . $nameuri;

					curl_setopt($process,CURLOPT_HTTPHEADER, array(
					"Accept: application/xml",
					"uri : ". $groupuri,
					"member: ". substr($members,1)
		
					));
					curl_setopt($process, CURLOPT_USERPWD, "admin:admin");
					//return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
					curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
					$returnedData = curl_exec($process);
					$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
				} else {
				
					$con=mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
						$row = array();
						$row['modelid'] = '1';
						$row['subject'] = $groupuri;
						$row['predicate'] = "http://www.tao.lu/Ontologies/TAOGroup.rdf#Members";
						$row['object'] = $nameuri;
						$row['author'] = self::TAO_HOST . 'ppsdm.rdf#superUser';
						$row['epoch'] = 'ppsdm';

						$sqlinsert = 'insert into statements (modelid,subject,predicate,object,l_language,author,epoch) values (
								"'.$row["modelid"].'",
						"'.$row["subject"].'",
						"'.$row["predicate"].'",
						"'.$row["object"].'",
						"",
						"'.$row["author"].'",
						CURRENT_TIMESTAMP
								
						)';
					//	echo '2';
				$insertresult = mysqli_query($con,$sqlinsert);
				//echo '3';
					mysqli_close($con);
		
				}
				echo 'Anda telah didaftarkan';
		} else {
			echo 'Anda sudah terdaftar sebelumnya';		
		}
				curl_close($process);	
				
	}
	
	
	
	public function update_testtaker($usermodel)
	{

		$rest_uri_string  = self::TAO_HOST . self::TAO_ROOT . '/taoSubjects/RestSubjects';
		$process = curl_init($rest_uri_string);
		curl_setopt($process, CURLOPT_PUT, 1);

		//needed using curl on apache
		curl_setopt($process, CURLOPT_POSTFIELDS, "");

		curl_setopt($process,CURLOPT_HTTPHEADER, array(
		"Accept: application/json",
		"label: ".$usermodel->username,
		"login: ".$usermodel->username,
		"password: ".$usermodel->password,
		));

		//set your credentials
		curl_setopt($process, CURLOPT_USERPWD, "admin:admin");

		//return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

		$returnedData = curl_exec($process);

		//allways check the http code returned
		$httpCode = curl_getinfo($process, CURLINFO_HTTP_CODE);

		$data = json_decode($returnedData, true);

		curl_close($process);
	
	}
	
	public function test() {
	
		
	}


	
}
							
							
							?>
