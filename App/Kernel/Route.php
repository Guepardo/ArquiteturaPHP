<?php 
namespace App\Kernel; 

class Route {
	public static $routes = [];

	public static function get($route, $foo){
		return self::set_new_route('GET', $route, $foo );  
	}

	public static function post($route, $foo){
		return self::set_new_route('POST', $route, $foo);  
	}

	public static function get_routes(){
		return self::$routes; 
	}

	private static function set_new_route($method, $route, $foo ){
		if(empty(self::$routes)){
			//A nível de protótipo, só trabalhareis com os métodos básicos
			self::$routes['GET']    = []; 
			self::$routes['POST']   = []; 
			// $routes['PUT']    = []; 
			// $routes['PATCH']  = []; 
			// $routes['DELETE'] = []; 
		}

		if(empty(self::$routes[$method])){
			self::$routes[$method] = []; 
		}

		// REMOVE: degub
		// array_push(self::$routes[$method], ['route' => $route, 'foo' => $foo]); 
		// var_dump(self::$routes); 
		return self::$routes[$method][$route] = $foo; 

		// return array_push(self::$routes[$method], ['route' => $route, 'foo' => $foo]); 
	}

}
