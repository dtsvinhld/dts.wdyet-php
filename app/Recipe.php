<?php

namespace App;

class Recipe{
	var $step, $recipe;
	function __construct($step, $recipe){
		$this -> step = $step;
		$this -> recipe = $recipe;
	}
}