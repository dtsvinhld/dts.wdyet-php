<?php

namespace App;

class EatingType{
	var $id, $name, $image;
	
	function __construct($id, $name, $image){
		$this -> id = $id;
		$this -> name = $name;
		$this -> image = $image;
	}
}