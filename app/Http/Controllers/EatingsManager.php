<?php

namespace App\Http\Controllers;

use App\C2DB;
use App\Message;
use App\Module;

class EatingsManager{
	
	function fav($userId){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, info, image FROM eating, favouriteeating WHERE eating.id = favouriteeating.eatingId 
			AND favouriteeating.id = $userId ORDER BY name ASC ");
			
			if(mysqli_num_rows($result) > 0){
				$length = mysqli_num_rows($result);
				$aEat = array();
				if($length > 0){
					while($row = mysqli_fetch_array($result)){
						array_push($aEat, array('id' => $row[0], 'name' => $row[1], 'image' => $row[3], 'info' => $row[2]));
					}
					array_push($array, new Message('Info', $length, $aEat));
				}
				else{
					array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
				}
			}
			else{
				array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function es($type){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, info, image FROM eating, eatingstype WHERE eating.id = eatingstype.id 
			AND eatingstype.idType = $type ORDER BY name ASC ");
			
			if(mysqli_num_rows($result) > 0){
				$length = mysqli_num_rows($result);
				$aEat = array();
				if($length > 0){
					while($row = mysqli_fetch_array($result)){
						array_push($aEat, array('id' => $row[0], 'name' => $row[1], 'image' => $row[3], 'info' => $row[2]));
					}
					array_push($array, new Message('Info', $length, $aEat));
				}
				else{
					array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
				}
			}
			else{
				array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
			}

		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function et(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT * FROM eatingtype");
			
			if(mysqli_num_rows($result) > 0){
				$ar = array();
				while($rows = mysqli_fetch_array($result)){
					array_push($ar, array('id' => $rows[0], 'name' => $rows[1], 'image' => $rows[2]));
				}
				array_push($array, new Message('Info', 'EatingType', $ar));
			}
			else
				array_push($array, new Message('Error', 'Invalid Eatings type', 'null'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function mat(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT rawmaterial.id, rawmaterial.name, rawmaterial.image, element.element, element.SoLuong,
					element.DonVi FROM rawmaterial, element WHERE rawmaterial.id = element.id ORDER BY rawmaterial.id, element.element ASC");
			if(mysqli_num_rows($result) > 0){
				$arr = array();
				$i = 0;
				$ele = array();
				while($rows = mysqli_fetch_array($result)){
					switch($i % 6){
						case 0:
							$ele = array();
							$id = $rows[0];
							$name = $rows[1];
							$image = $rows[2];
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$cBeo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 1:
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$cBot = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 2:
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$cDam = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 3:
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$cXo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 4:
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$kalo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 5:
							array_push($ele, array('name' => $rows[3], 'soluong' => $rows[4], 'donvi' => $rows[5]));
							//$h2o = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							array_push($arr, array('id' => $id, 'name' => $name, 'image' => $image, 'element' => $ele));
							break;
					}
					$i += 1;
				}
				array_push($array, new Message('Info', 'Material', $arr));
			}
			else
				array_push($array, new Message('Error', 'Material', 'null'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function option($type){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, image FROM eating, eatingstype WHERE eating.id = eatingstype.id 
					AND eatingstype.idType = $type");
			
			if(mysqli_num_rows($result) > 0){
				$arr = array();
				while($row = mysqli_fetch_array($result)){
					array_push($arr, array('id' => $row[0], 'name' => $row[1], 'image' => $row[2]));
				}
				array_push($array, new Message('Info', 'Eatings', $arr));
			}
			else{
				array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function random($type, $key){
		$key = explode('_', $key);
		$keyId = '';
		foreach($key as $value){
			$keyId .=  ' and eating.id <> ' . $value;
		}
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, image FROM eating, eatingstype WHERE eating.id = eatingstype.id 
					AND eatingstype.idType = $type" . $keyId);
			
			$length = mysqli_num_rows($result);
			if($length > 0){
				$position = rand(0, $length);
				$i = 0;
				while($row = mysqli_fetch_array($result)){
					if($i == $position){
						array_push($array, new Message('Info', 'Eating', array('id' => $row[0], 'name' => $row[1], 'image' => $row[2])));
						break;
					}
					$i += 1;
				}
			}
			else{
				array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function getEatingByID($id, $idUser){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$rate = mysqli_query($Connection, "SELECT ROUND(SUM(rateeating.rate)/COUNT(*), 1), COUNT(*) FROM rateeating WHERE eatingId = $id");
			if(mysqli_num_rows($rate) > 0){
				$rate = mysqli_fetch_array($rate);
				$rating = $rate[0];
				if($rating == null){
					$rating = '0.0';
					$rates = 0;
				}
				else{
					$rating = round($rating, 1);
					$rates = $rate[1];
				}
			}
			else{
				$rating = '0.0';
				$rates = 0;
			}
			
			$views = mysqli_query($Connection, "SELECT COUNT(*) FROM vieweating WHERE idEating = $id");
			if(mysqli_num_rows($views) > 0){
				$views = mysqli_fetch_array($views);
				$views = $views[0];
				$views += 1;
			}
			else{
				$views = 1;
			}
			
			$result = mysqli_query($Connection, "SELECT eating.id, eating.name, eating.image, eating.info, eating.video FROM `eating` WHERE eating.id = $id");
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result);
				$result2 = mysqli_query($Connection, "SELECT rawmaterial.name, menurawmaterial.SoLuong FROM rawmaterial, menurawmaterial WHERE
						rawmaterial.id = menurawmaterial.idRMa and menurawmaterial.id = $id");
				$arrayEle = array();
				while($rows = mysqli_fetch_array($result2)){
					array_push($arrayEle, array('name' => $rows[0], 'soluong' => $rows[1]));
				}
				$aRe = array();
				$re = mysqli_query($Connection, "SELECT * FROM recipe WHERE id = $id");
				while($rs = mysqli_fetch_array($re)){
					array_push($aRe, array('step' => $rs[1], 'recipe' => $rs[2]));
				}
				
				array_push($array, new Message('Info', 'Eating', array('id' => $row[0], 'name' => $row[1], 'image' => $row[2], 'info' => $row[3],
						 'elements' => $arrayEle, 'video' => $row[4], 'recipe' => $aRe, 'rating' => $rating, 'rates' => $rates, 'views' => $views)));
				$cD = (new Module()) -> timeNow();
				mysqli_query($Connection, "INSERT INTO vieweating VALUES(0, $id, $idUser, '$cD')");
			}
			else{
				array_push($array, new Message('Error', 'No Eating', 'Invalid ID Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function mfd($id, $day){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT rawmaterial.id, rawmaterial.name, menurawmaterial.SoLuong FROM menurawmaterial, rawmaterial, 
					menueating WHERE rawmaterial.id = menurawmaterial.idRMa AND menurawmaterial.id = menueating.idEating AND menueating.id = $id 
					AND menueating.day = $day ORDER BY rawmaterial.name");
			$mat = array();
			while($r = mysqli_fetch_array($result)){
				array_push($mat, array('id' => $r[0], 'name' => $r[1], 'soluong' => $r[2]));
			}
			array_push($array, new Message('Info', 'MfD', $mat));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function mow($userId){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$rst = mysqli_query($Connection, "SELECT menushow FROM user WHERE id = $userId");
			$menuId = mysqli_fetch_array($rst);
			$menuId = $menuId[0];
			
			$result = mysqli_query($Connection, "SELECT eating.id, eating.name, eating.image, menueating.day, menueating.meal FROM eating, menueating 
					WHERE eating.id = menueating.idEating AND menueating.id = $menuId ORDER BY menueating.day, menueating.meal ASC");
			$eatings = array();
			while($r = mysqli_fetch_array($result)){
				array_push($eatings, array('eatingId' => $r[0], 'name' => $r[1], 'image' => $r[2], 'day' => $r[3], 'meal' => $r[4]));
			}
			
			$menu = mysqli_query($Connection, "SELECT * FROM menu WHERE id = $menuId");
			$menu = mysqli_fetch_array($menu);
			$menu = array('id' => $menuId, 'days' => $menu[3], 'meals' => $menu[4], 'menu' => $eatings);
			
			$m = 'Menu';
			if($menuId == $userId){
				$m = 'My Menu';
			}
			array_push($array, new Message('Info', $m, $menu));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
}