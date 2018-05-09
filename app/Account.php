<?php

namespace App;

class Account{
	var $id, $username, $password, $fullname, $sdt, $email, $semail, $days, $meals, $createDate, $state, $keycode;
		
		function __construct($id, $username, $password, $fullname, $sdt, $email, $semail, $days, $meals, $createDate, $state, $keycode){
			$this -> id = $id;
			$this -> username = $username;
			$this -> password = $password;
			$this -> fullname = $fullname;
			$this -> sdt = $sdt;
			$this -> email = $email;
			$this -> semail = $semail;
			$this -> days = $days;
			$this -> meals = $meals;
			$this -> createDate = $createDate;
			$this -> state = $state;
			$this -> keycode = $keycode;
		}
}
?>