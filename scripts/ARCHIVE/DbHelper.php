<?php

class MyDB
{

private $_Con;
const MYSQL_USER = "ppsdm";
const MYSQL_PASS = "ppsdM2014";
const MYSQL_HOST = "localhost";
const MYSQL_NAME = "psikotes";


	function __construct()
	{
		$this->_Con = mysql_connect(self::MYSQL_HOST, self::MYSQL_USER, self::MYSQL_PASS) or die("Unable to connect to MySQL");

		mysql_select_db(self::MYSQL_NAME, $this->_Con);
				if (mysql_error()) {
				exit('Connection to <b>' . self::MYSQL_NAME . '</b> failed.');
			}
	}

	 public function close()
	 {
		mysql_close($this->_Con);
	 }

	public function getAll()
	{
		$query = "select * from datascanning";
		$result = mysql_query($query);
		return $result;
	}
	
	public function getRow($nama)
	{
		$query = "select * from datascanning where profile_id ='" . $nama."'";
		$result = mysql_fetch_array(mysql_query($query));
		return $result;
	}
	
	public function scale($name,$value)
	{
		$query = "select scaled_value from ref_scaling where scaling_name='" . $name."' AND raw_value='".$value."'";
		$result = mysql_fetch_array(mysql_query($query));
		return $result[0];
	
	}
	
	public function scale2($name,$value)
	{
		$query = "select scaled_value from ref_scaling where scaling_name='" . $name."' AND raw_value<='".$value."' order by scaled_value DESC limit 1";
		//select scaled_value from ref_scaling where scaling_name='130to7' AND raw_value<= '130' 
		$result = mysql_fetch_array(mysql_query($query));
		return $result[0];
	
	}
	 
}
	
	 ?>
