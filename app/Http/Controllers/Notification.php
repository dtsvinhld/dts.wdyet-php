<?php

namespace App\Http\Controllers;

use App\C2DB;
use App\Message;

class Notification{
	
	function notify($userId){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT notify.notify, notify.time, notifyforuser.icon FROM notify, notifyforuser 
					WHERE notify.id = notifyforuser.id AND notifyforuser.idUser = $userId ORDER BY notify.id DESC");
			if(mysqli_num_rows($result)>0){
				$arr = array();
				while($r = mysqli_fetch_array($result)){
					array_push($arr, array('title' => $r[0], 'time' => $r[1], 'icon' => $r[2]));
				}
				array_push($array, new Message('Info', 'Notify', $arr));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
	}
	
	function getMaterialforMeal($menuId, $day, $meal){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$query = mysqli_query($Connection, "SELECT idEating FROM menueating WHERE id = '$menuId' AND day = '$day' AND meal = '$meal'");
			if(mysqli_num_rows($query) > 0){
				$idE = mysqli_fetch_array($query);
				$eId = $idE[0];
				$mat = mysqli_query($Connection, "SELECT rawmaterial.name, menurawmaterial.SoLuong from rawmaterial, menurawmaterial WHERE rawmaterial.id = menurawmaterial.idRMa AND menurawmaterial.id = '$eId'");
				$mArray = array();
				if(mysqli_num_rows($mat) > 0){
					while($r = mysqli_fetch_array($mat)){
						array_push($mArray, array('name' => $r[0], 'sl' => $r[1]));
					}
				}
				array_push($array, new Message('Info', 'ID Eating', $mArray));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
	}
	
	function addDevice($device){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT * FROM devices WHERE device = '$device'");
			if(mysqli_num_rows($result) == 0){
				$query = mysqli_query($Connection, "INSERT INTO devices VALUES(0, '$device')");
				if($query){
					array_push($array, new Message('Info', 'Add Device', 'add successful'));
				}
				else{
					array_push($array, new Message('Error', 'Add Device', 'add failed'));
				}
			}
			else{
				array_push($array, new Message('Info', 'Add Device', 'Invalid device'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
	}
	
	function addNotifyforUser($idN, $idU, $mId, $day, $meal){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT eating.image FROM eating, menueating WHERE eating.id = menueating.idEating 
					AND menueating.id = $mId AND menueating.day = $day AND menueating.meal = $meal");
					
			$eId = mysqli_fetch_array($result);
			$eId = $eId[0];
			
			$query = mysqli_query($Connection, "INSERT INTO notifyforuser VALUES($idN, $idU, '$eId')");
			if($query){
				array_push($array, new Message('Info', 'Add Notifyfouser', 'successful'));
			}
			else{
				array_push($array, new Message('Error', 'Add Notifyfouser', 'Add failed'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
	}
	
	function getDevices(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT device FROM devices");
			if(mysqli_num_rows($result) > 0)
				while($device = mysqli_fetch_array($result))
					array_push($array, $device[0]);
		}
		
		return $array;
	}
	
	function sendMessage($type){
		$devices = $this -> getDevices();
				$message = '';
				$title = '';
				$text = '';
		$day = date('D');
		$thumay = '';
		switch($day){
			case 'Mon':
				$thumay = 'thứ Hai';
				break;
				
			case 'Tue':
				$thumay = 'thứ Ba';
				break;
				
			case 'Wed':
				$thumay = 'thứ Tư';
				break;
				
			case 'Thu':
				$thumay = 'thứ Năm';
				break;
				
			case 'Fri':
				$thumay = 'thứ Sáu';
				break;
				
			case 'Sat':
				$thumay = 'thứ Bảy';
				break;
				
			case 'Sun':
				$thumay = 'Chủ Nhật';
				break;
		}
		switch($type){
			case 1:
				$message = 'Breakfast';
				$title = 'Mua đồ nấu bữa sáng nào';
				$text = 'Nguyên liệu cho bữa sáng ' . $thumay;
				break;
				
			case 2:
				$message = 'Lunch';
				$title = 'Mua đồ nấu bữa trưa nào';
				$text = 'Nguyên liệu cho bữa sáng ' . $thumay;
				break;
				
			case 3:
				$message = 'Dinner';
				$title = 'Mua đồ nấu bữa tối nào';
				$text = 'Nguyên liệu cho bữa sáng ' . $thumay;
				break;
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$currentTime = date('Y-m-d H:i:s');
		$Connection = (new C2DB()) -> getC2DB();
		$addN = mysqli_query($Connection, "INSERT INTO notify VALUES(0, '$title', '$text', '$currentTime', '')");
		$idN = 0;
		if($addN){
			$id = mysqli_query($Connection, "SELECT id FROM notify WHERE title = '$title' AND notify = '$text' AND time = '$currentTime'");
			if(mysqli_num_rows($id) > 0){
				$id = mysqli_fetch_array($id);
				$idN = $id[0];
			}
		}
		foreach($devices as $device){
			$this -> sendFCM2Android($device, $message, array('title' => $title, 'text' => $text, 'idN' => $idN, 'day' => $day));
		}
	}
	
	function sendFCM2Android($devices, $message, $data){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$msg = array(
			'message' => $message,
			'data' => $data
		);            
		$fields = array();
		$fields['data'] = $msg;
		if (is_array($devices)) {
			$fields['registration_ids'] = $devices;
		} else {
			$fields['registration_ids'] = array($devices);
		}
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key=AIzaSyD2sUOXx3C4vsq7PPEScPlUR0SCAA5FWac'
		);   
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Error: '  .  curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}
}