<?php 
namespace App\Kernel; 

class Request{
	public static function get_method(){
		return $_SERVER['REQUEST_METHOD']; 
	}

	public static function get_param_array(){
		return $_REQUEST; 
	}
}