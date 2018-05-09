<?php

namespace App;

define("HOSTLINK","localhost/20180322WDYET/");
define("HOSTFILE","C:/xampp/htdocs/20180322WDYET/");

define("HOSTNAME","localhost");
define("USERNAME","root");
define("PASSWORD","");
define("DATABASENAME","201803070333dtsvinhldwdyet");

class C2DB{
	
	function getC2DB(){
		$connect = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASENAME);
		if($connect)
			mysqli_set_charset($connect, 'utf8');
		else
			return false;
		return $connect;
	}
	
}
?>