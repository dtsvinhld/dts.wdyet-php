<?php

namespace App\Http\Controllers;

use App\C2DB;
use App\Message;
use App\Eating;
use App\Recipe;
use App\Element;
use App\EatingType;
use App\Menu;
use App\MenuEating;
use App\Material;
use App\Module;

class EatingManager{
	
	function getEatingbyUserID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$lists = mysqli_query($Connection, "SELECT eating.id, eating.name, eating.image, eating.creator, user.fullname, eating.createdDate FROM eating, user WHERE eating.creator = user.id AND eating.creator = $id");
			
			if(mysqli_num_rows($lists) > 0){
				
				$menu = array();
				while($list = mysqli_fetch_array($lists)){
					array_push($menu, array('id' => $list[0], 'name' => $list[1], 'image' => $list[2], 'creator' => $list[3], 'fullname' => $list[4], 'createdDate' => $list[5], 'rate' => ''));
				}
				array_push($array, new Message('Info', 'Eating', $menu));
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
		
	}
	
	function getEatingRatedbyUserID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$lists = mysqli_query($Connection, "SELECT eating.id, eating.name, eating.image, eating.creator, user.fullname, eating.createdDate, rateeating.rate FROM eating, user, rateeating WHERE eating.id = rateeating.eatingId AND rateeating.userId = user.id AND rateeating.userId = $id");
			
			if(mysqli_num_rows($lists) > 0){
				
				$menu = array();
				while($list = mysqli_fetch_array($lists)){
					array_push($menu, array('id' => $list[0], 'name' => $list[1], 'image' => $list[2], 'creator' => $list[3], 'fullname' => $list[4], 'createdDate' => $list[5], 'rate' => $list[6]));
				}
				array_push($array, new Message('Info', 'Eating', $menu));
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
		
	}
	
	function getMenubyUserID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$lists = mysqli_query($Connection, "SELECT menu.id, menu.name, user.id, user.fullname, menu.createdDate, menu.days, menu.meals FROM menu, user WHERE menu.idCreator = user.id AND menu.idCreator = $id");
			
			if(mysqli_num_rows($lists) > 0){
				
				$menu = array();
				while($list = mysqli_fetch_array($lists)){
					array_push($menu, new Menu($list[0], $list[1], $list[3], $list[5], $list[6], $list[2], $list[4], '', ''));
				}
				array_push($array, new Message('Info', 'Eating', $menu));
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Eating!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
		
	}
	
	function getMenuRatedbyUserID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$lists = mysqli_query($Connection, "SELECT menu.id, menu.name, user.id, user.fullname, menu.createdDate, menu.days, menu.meals, ratemenu.rate FROM menu, user, ratemenu WHERE menu.idCreator = user.id AND menu.id = ratemenu.menuId AND ratemenu.userId = $id ORDER BY ratemenu.rate DESC");
			
			if(mysqli_num_rows($lists) > 0){
				
				$menu = array();
				while($list = mysqli_fetch_array($lists)){
					array_push($menu, new Menu($list[0], $list[1], $list[3], $list[5], $list[6], $list[2], $list[4], $list[7], ''));
				}
				array_push($array, new Message('Info', 'Eating', $menu));
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Eating!'));
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
				$result2 = mysqli_query($Connection, "SELECT rawmaterial.name, menurawmaterial.SoLuong FROM rawmaterial, menurawmaterial WHERE rawmaterial.id = menurawmaterial.idRMa and menurawmaterial.id = $id");
				$arrayEle = array();
				while($rows = mysqli_fetch_array($result2)){
					array_push($arrayEle, new Element($rows[0], $rows[1]));
				}
				$aRe = array();
				$re = mysqli_query($Connection, "SELECT * FROM recipe WHERE id = $id");
				while($rs = mysqli_fetch_array($re)){
					array_push($aRe, new Recipe($rs[1], $rs[2]));
				}
				
				array_push($array, new Message('Info', 'Eating', new Eating($row[0], $row[1], $row[2], $row[3], $arrayEle, $row[4], $aRe, $rating, $rates, $views)));
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
	
	function getEatingByTypeLimit100($type, $limit){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, info, image FROM eating, eatingstype WHERE eating.id = eatingstype.id AND eatingstype.idType = $type ORDER BY name ASC LIMIT $limit, 100");
			
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result);
				$length = mysqli_num_rows($result);
				$aEat = array();
				if($length > 0){
					while($row = mysqli_fetch_array($result)){
						array_push($aEat, new Eating($row[0], $row[1], $row[3], $row[2], '', '', '', '', '', ''));
					}
					array_push($array, new Message('Info', $length, $aEat));
				}
				else{
					array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
				}
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function getEatingByType($type){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, info, image FROM eating, eatingstype WHERE eating.id = eatingstype.id AND eatingstype.idType = $type ORDER BY name ASC ");
			
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result);
				$length = mysqli_num_rows($result);
				$aEat = array();
				if($length > 0){
					while($row = mysqli_fetch_array($result)){
						array_push($aEat, new Eating($row[0], $row[1], $row[3], $row[2], '', '', '', '', '', ''));
					}
					array_push($array, new Message('Info', $length, $aEat));
				}
				else{
					array_push($array, new Message('Error', 'No Eating', 'Invalid Eating!'));
				}
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function getEatingsType(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT * FROM eatingtype");
			
			if(mysqli_num_rows($result) > 0){
				$ar = array();
				while($rows = mysqli_fetch_array($result)){
					array_push($ar, new EatingType($rows[0], $rows[1], $rows[2]));
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

	function getEatingRandom($type, $key){
		
		$key = explode('_', $key);
		$keyId = '';
		foreach($key as $value){
			$keyId .=  ' and eating.id <> ' . $value;
		}
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, image FROM eating, eatingstype WHERE eating.id = eatingstype.id AND eatingstype.idType = $type" . $keyId);
			
			$length = mysqli_num_rows($result);
			if($length > 0){
				$position = rand(0, $length);
				$i = 0;
				while($row = mysqli_fetch_array($result)){
					if($i == $position){
						array_push($array, new Message('Info', 'Eating', new Eating($row[0], $row[1], $row[2], '', '', '', '')));
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

	function getEatingsOption($type){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$result = mysqli_query($Connection, "SELECT eating.id, name, image FROM eating, eatingstype WHERE eating.id = eatingstype.id AND eatingstype.idType = $type");
			
			if(mysqli_num_rows($result) > 0){
				$arr = array();
				while($row = mysqli_fetch_array($result)){
					array_push($arr, new Eating($row[0], $row[1], $row[2], '', '', '', ''));
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

	function addMenu($name, $info, $days, $meals, $idCreator, $ids){
		
		$days = explode('_', $days);
		$day = count(array_unique($days));
		$meals = explode('_', $meals);
		$meal = count(array_unique($meals));
		$ids = explode('_', $ids);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$createdDate = date('Y-m-d H:i:s');
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$query = mysqli_query($Connection, "INSERT INTO menu VALUES(0, '$name', '$info', $day, $meal, $idCreator, '$createdDate', 0)");
			if($query){
				$id = mysqli_query($Connection, "SELECT id FROM menu WHERE idCreator = $idCreator ORDER BY id DESC");
				$id = mysqli_fetch_array($id);
				$id = $id[0];
					
				for($i=0; $i<count($ids); $i+=1){
					$idEat = $ids[$i];
					$d = $days[$i];
					$m = $meals[$i];
					$query1 = mysqli_query($Connection, "INSERT INTO menueating VALUES($id, $idEat, $d, $m)");
					if(!$query1){
						array_push($array, new Message('Error', 'AddMenu', 'Syntax Error!'));
						return json_encode($array);
					}
				}
				array_push($array, new Message('Info', 'Successful', 'Add Menu Successful!'));
			}
			else
				array_push($array, new Message('Error', 'AddMenu', 'Syntax Error!'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}

	function editMenu($id, $day, $meals, $ids){
		
		$meals = explode('_', $meals);
		$ids = explode('_', $ids);
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			for($i = 0; $i < count($meals); $i += 1){
				$idEating = $ids[$i];
				$meal = $meals[$i];
				$query = mysqli_query($Connection, "UPDATE menueating SET idEating = $idEating WHERE id = $id and day = $day and meal = $meal");
				if(!$query){
					array_push($array, new Message('Error', 'AddMenu', 'Syntax Error!'));
					return json_encode($array);
				}
			}
			array_push($array, new Message('Info', 'Successful', 'Edit Menu Successful!'));
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function getMenuofWeek($idUser){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT id FROM menu WHERE idCreator = 1 ORDER BY id DESC");
			$id = mysqli_fetch_array($result);
			$id = $id[0];
			$queryString = "SELECT menu.id, menu.name, menu.info, menu.days, menu.meals, idCreator, menu.createdDate, eating.id, eating.name, eating.image, day, meal FROM menu, `menueating`, eating WHERE menu.id = menueating.id AND menueating.idEating = eating.id and menu.id = $id ORDER BY menu.id DESC, day ASC, meal ASC";
			$m = 'Menu';
			
			if($idUser != 0){
				$result = mysqli_query($Connection, "SELECT id FROM menu WHERE idCreator = $idUser ORDER BY id DESC");
				if(mysqli_num_rows($result) > 0){
					
					if($idUser != 1)
						$m = 'My Menu';
					
					$id = mysqli_fetch_array($result);
					$id = $id[0];
					$queryString = "SELECT menu.id, menu.name, menu.info, menu.days, menu.meals, idCreator, menu.createdDate, eating.id, eating.name, eating.image, day, meal FROM menu, `menueating`, eating WHERE menu.id = menueating.id AND menueating.idEating = eating.id and menu.id = $id ORDER BY day, meal ASC";
				}
			}
			
			$menu = mysqli_query($Connection, $queryString);
			
			if(mysqli_num_rows($menu) > 0){
				while($row = mysqli_fetch_array($menu)){
				array_push($array, new Message('Info', $m, new MenuEating($row[0], $row[4], $row[10], $row[11], $row[7], $row[8], $row[9])));
					/*$iii += 1;
					if($iii == mysqli_num_rows($menu)){
						array_push($ar, new Menu($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $arr));
					}*/
				}
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Menu!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}
	
	function getMenubyID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			
			$menu = mysqli_query($Connection, "SELECT menu.id, menu.name, menu.info, menu.days, menu.meals, idCreator, menu.createdDate, eating.id, eating.name, eating.image, day, meal FROM menu, `menueating`, eating WHERE menu.id = menueating.id AND menueating.idEating = eating.id and menu.id = $id");
			
			if(mysqli_num_rows($menu) > 0){
				$menus = array();
				while($row = mysqli_fetch_array($menu)){
					array_push($menus, new MenuEating($row[0], $row[4], $row[10], $row[11], $row[7], $row[8], $row[9]));
					/*$iii += 1;
					if($iii == mysqli_num_rows($menu)){
						array_push($ar, new Menu($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $arr));
					}*/
				}
				array_push($array, new Message('Info', 'Menu', $menus));
			}
			else{
				array_push($array, new Message('Error', 'No Menu', 'Invalid ID Menu!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());

		return json_encode($array);
	}

	function getMaterial(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT rawmaterial.id, rawmaterial.name, rawmaterial.image, element.element, element.SoLuong, element.DonVi FROM rawmaterial, element WHERE rawmaterial.id = element.id ORDER BY rawmaterial.id, element.element ASC");
			if(mysqli_num_rows($result) > 0){
				$arr = array();
				$i = 0;
				while($rows = mysqli_fetch_array($result)){
					switch($i % 6){
						case 0:
							$id = $rows[0];
							$name = $rows[1];
							$image = $rows[2];
							$cBeo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 1:
							$cBot = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 2:
							$cDam = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 3:
							$cXo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 4:
							$kalo = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							break;
							
						case 5:
							$h2o = $rows[3] . ': ' . $rows[4] . ' ' . $rows[5];
							array_push($arr, new Material($id, $name, $image, $kalo, $h2o, $cBeo, $cDam, $cBot, $cXo));
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
	
}

?>