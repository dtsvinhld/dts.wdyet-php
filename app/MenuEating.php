<?php

namespace App;

class MenuEating{
	var $id, $meals, $day, $meal, $idEating, $nameEating, $imageEating;
		
	function __construct($id, $meals, $day, $meal, $idEating, $nameEating, $imageEating){
		$this -> id = $id;
		$this -> meals = $meals;
		$this -> day = $day;
		$this -> meal = $meal;
		$this -> idEating = $idEating;
		$this -> nameEating = $nameEating;
		$this -> imageEating = $imageEating;
	}
}