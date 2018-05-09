<?php

namespace App;

class Menu{
	var $id, $name, $info, $days, $meals, $idCreator, $createdDate, $views, $menu;
		
	function __construct($id, $name, $info, $days, $meals, $idCreator, $createdDate, $views, $menu){
		$this -> id = $id;
		$this -> name = $name;
		$this -> info = $info;
		$this -> days = $days;
		$this -> meals = $meals;
		$this -> idCreator = $idCreator;
		$this -> createdDate = $createdDate;
		$this -> views = $views;
		$this -> menu = $menu;
	}
}