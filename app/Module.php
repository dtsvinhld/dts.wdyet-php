<?php

namespace App;

class Module{
	function timeNow(){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		return date('Y-m-d H:i:s');
	}
}