<?php

namespace App;

class Eating{
	var $id, $name, $image, $info, $elements, $video, $recipe, $rating, $rates, $views;
	
	function __construct($id, $name, $image, $info, $elements, $video, $recipe, $rating, $rates, $views){
		$this -> id = $id;
		$this -> name = $name;
		$this -> image = $image;
		$this -> info = $info;
		$this -> elements = $elements;
		$this -> video = $video;
		$this -> recipe = $recipe;
		$this -> rating = $rating;
		$this -> rates = $rates;
		$this -> views = $views;
	}
}