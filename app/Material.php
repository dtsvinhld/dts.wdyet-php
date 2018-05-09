<?php

namespace App;

class Material{
	var $id, $name, $image, $kalo, $h2o, $cBeo, $cDam, $cBot, $cXo;
	
	function __construct($id, $name, $image, $kalo, $h2o, $cBeo, $cDam, $cBot, $cXo){
		$this -> id = $id;
		$this -> name = $name;
		$this -> image = $image;
		$this -> kalo = $kalo;
		$this -> h2o = $h2o;
		$this -> cBeo = $cBeo;
		$this -> cDam = $cDam;
		$this -> cBot = $cBot;
		$this -> cXo = $cXo;
	}
}
?>