<?php
require_once('Config.php');
class MyDB
{

private $_Con;


	function __construct($dbname)
	{
	switch ($dbname){
	
	case 'ppsdm' :
				$this->_Con = mysqli_connect(Config::PPSDM_DB_HOST, Config::PPSDM_DB_USER, Config::PPSDM_DB_PASS) or die("Unable to connect to MySQL");
				mysqli_select_db($this->_Con,Config::PPSDM_DB_NAME);
				if (mysqli_connect_errno()) {
				exit('Connection to <b>' . Config::PPSDM_DB_NAME . '</b> failed.');
				}
				break;
		case 'tao' :
				$this->_Con = mysqli_connect(Config::TAO_DB_HOST, Config::TAO_DB_USER, Config::TAO_DB_PASS) or die("Unable to connect to MySQL");
				mysqli_select_db($this->_Con,Config::TAO_DB_NAME);
				if (mysqli_connect_errno()) {
				exit('Connection to <b>' . Config::TAO_DB_NAME . '</b> failed.');
				}
				break;
		case 'results' :
				$this->_Con = mysqli_connect(Config::RESULTS_DB_HOST, Config::RESULTS_DB_USER, Config::RESULTS_DB_PASS) or die("Unable to connect to MySQL");
				mysqli_select_db($this->_Con,Config::RESULTS_DB_NAME);
				if (mysqli_connect_errno()) {
				exit('Connection to <b>' . Config::RESULTS_DB_NAME . '</b> failed.');
				}
				break;
	
	}

	}

	 public function close()
	 {
		mysqli_close($this->_Con);
	 }

	public function getAll()
	{
		$query = "select * from datascanning";
		$result = mysqli_query($this->_Con, $query);
		return $result;
	}
	
	public function getRow($nama)
	{
		$query = "select * from datascanning where profile_id ='" . $nama."'";
		$result = mysqli_fetch_array(mysqli_query($this->_Con, $query));
		return $result;
	}
	
	public function scale($name,$value)
	{
		$query = "select scaled_value from ref_scaling where scaling_name='" . $name."' AND raw_value='".$value."'";
		$result = mysqli_fetch_array(mysqli_query($this->_Con, $query));
		return $result[0];
	
	}
	
	public function scale2($name,$value)
	{
		$query = "select scaled_value from ref_scaling where scaling_name='" . $name."' AND raw_value<='".$value."' order by scaled_value DESC limit 1";
		//select scaled_value from ref_scaling where scaling_name='130to7' AND raw_value<= '130' 
		$result = mysqli_fetch_array(mysqli_query($this->_Con, $query));
		return $result[0];
	
	}
	
	public function test($delivery_result)
	{
		$que = 'select * from results where tao_delivery_result = "'. $delivery_result . '"';
		
		
		$result = mysqli_query($this->_Con, $que);

			while ($row = mysqli_fetch_array($result)){
				echo $row['tao_delivery'];
				}
		return;
	
	}
	
	public function getResult($delivery_result)
	{
		$que = 'select * from results where tao_delivery_result = "'. $delivery_result . '"';		
		$result = mysqli_query($this->_Con, $que);
		return $result;
	}
	
	 
}
	
	 ?>