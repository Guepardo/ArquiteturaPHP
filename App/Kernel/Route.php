<?php 
namespace App\Kernel; 

class Route {
	public static $routes = [];

	// $routes['GET'] = []; 
	// $routes['POST']  = []; 

	public static function get($path, $foo){
		$foo(); 
	}

	private static function set_new_route($method, $route, $foo )
}
