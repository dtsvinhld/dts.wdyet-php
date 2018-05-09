<?php

namespace App\Http\Controllers;

use App\C2DB;
use App\Message;

class News{
	function getNews(){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		$array = array();
		
		if($Connection){
			$result = mysqli_query($Connection, "SELECT * FROM news ORDER BY id DESC");
			if(mysqli_num_rows($result) > 0){
				$n = array();
				while($new = mysqli_fetch_array($result)){
					array_push($n, array('id' => $new[0], 'title' => $new[1], 'image' => $new[2], 'createdDate' => $new[3], 'link' => 'news/' . $new[0]));
				}
				array_push($array, new Message('Info', 'News', $n));
			}
			else{
				array_push($array, new Message('Error', 'No News', 'Invalid News!'));
			}
		}
		else
			array_push($array, (new Message()) -> messageErrorNoConnection());
		
		return json_encode($array);
	}
	
	function getNewsbyID($id){
		
		$Connection = (new C2DB()) -> getC2DB();
		
		if($Connection){
			$result = mysqli_query($Connection, 'SELECT link FROM news WHERE id = ' . $id);
			if(mysqli_num_rows($result) > 0){
				$data = mysqli_fetch_array($result);
				return $data[0] . '<style>html{font-family: arial;width: 100%;text-align: justify;margin-top:10px;}body{width:90%;margin: 0 auto;}img{width:100%;}</style>';
			}
		}
	}
}