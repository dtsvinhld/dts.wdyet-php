<?php

namespace App;

class Message{
	var $title, $notify, $info;
	
	function __construct($title, $notify, $info){
		$this -> title = $title;
		$this -> notify = $notify;
		$this -> info = $info;
	}
	
	function messageErrorNoConnection(){
		return (new Message('Error', 'No Connection', 'Can not connect to server!'));
	}
}
?>