<?php

namespace App\Http\Controllers;

use App\C2DB;
use App\Message;
use App\Account;

class AccountManager{
	
	function login($username, $password){
		
		$array = array();
		
		$Connection = (new C2DB()) -> getC2DB();
		if($Connection){
			
			if($username != null && $password != null){
				$password = md5($password . 'DTSVinhLD@2018');
				$result = mysqli_query($Connection, "SELECT * FROM user WHERE username = '$username' and password = '$password'");
				if(mysqli_num_rows($result) > 0){
					$row = mysqli_fetch_array($result);
					$state = $row[10];
					if($state == 1)
						array_push($array, new Message('Info', 'USER', new Account($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11])));
					else
						array_push($array, new Message('Error', 'Activate Account', 'Account is not activated'));
				}
				else{
					array_push($array, new Message('Error', 'No info USER', 'Invalid account or password!'));
				}
			}
			else{
				array_push($array, new Message('Error', 'No info USER', 'Does not exist username or password!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}

	function register($username, $password, $fullname){
		
		$array = array();
		
		if($username != null && $password != null && $fullname != null){
			$Connection = (new C2DB()) -> getC2DB();
			if($Connection){
				
				$result = mysqli_query($Connection, "SELECT * FROM user WHERE username = '$username'");
				
				$checkAccount = mysqli_num_rows($result) == 0 ? true : false;
				
				if($checkAccount){
					$keycode = rand(100000, 999999);
					$createdDate = date('Y-m-d H:i:s');
					$password = md5($password . 'DTSVinhLD@2018');
					$query = mysqli_query($Connection, "INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `sdt`, `email`, `semail`, `days`, 
							`meals`, `createdDate`, `state`, `keycode`, `menushow`) VALUES (NULL, '$username', '$password', '$fullname', '', '', 0, 0,
							'0', '$createdDate', '1', $keycode, '2')");
					if($query)
						array_push($array, new Message('Info', 'Successful', 'Sign Up Successful!'));
					else
						array_push($array, new Message('Error', 'Register', 'Syntax Error!'));
				}
				else
					array_push($array, new Message('Error', 'User', 'Username available!'));
			}
			else
				array_push($array, (new Message()) -> messageErrorNoConnection());
		}
		else
			array_push($array, new Message('Error', 'No information', 'User information is missing!'));

		return json_encode($array);
	}
	
	function changeFullname($username, $fullname){
		
		$array = array();
		
		$Connection = (new C2DB()) -> getC2DB();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT * FROM user WHERE username = '$username'");
			
			$checkAccount = mysqli_num_rows($result) == 0 ? false : true;
			
			if($checkAccount){
				$query = mysqli_query($Connection, "UPDATE user SET fullname = '$fullname' WHERE username = '$username'");
				if($query)
					array_push($array, new Message('Info', 'Successful', 'Fullname Changed!'));
				else
					array_push($array, new Message('Error', 'ChangeFullname', 'Syntax Error!'));
			}
			else
				array_push($array, new Message('Error', 'User', 'Username available!'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function changePassword($username, $password){
		
		$array = array();
		
		$Connection = (new C2DB()) -> getC2DB();
		$password = md5($password . 'DTSVinhLD@2018');
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT * FROM user WHERE username = '$username'");
			
			$checkAccount = mysqli_num_rows($result) == 0 ? false : true;
			
			if($checkAccount){
				$query = mysqli_query($Connection, "UPDATE user SET password = '$password' WHERE username = '$username'");
				if($query)
					array_push($array, new Message('Info', 'Successful', 'Password Changed!'));
				else
					array_push($array, new Message('Error', 'ChangePassword', 'Syntax Error!'));
			}
			else
				array_push($array, new Message('Error', 'User', 'Username available!'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
}

?>