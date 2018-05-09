<?php

namespace App;

class Element{
	var $name, $soluong;
	function __construct($name, $soluong){
		$this -> name = $name;
		$this -> soluong = $soluong;
	}
}