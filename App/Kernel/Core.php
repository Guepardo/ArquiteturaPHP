<?php 
namespace App\Kernel; 

use App\Kernel\Route; 
use App\Kernel\Request; 

class Core{
	private $controllers_namespace = 'App\\Controller\\'; 

	public function handle_requests(){
		/*
			Identificando qual é o tipo do request; 
		*/
		$request_method = Request::get_method(); 

		/*
			Recolhendo os parâmetros em um array. 
		*/
		$params = Request::get_param_array(); 

		/*
			Recolhendo as rotas escritas pelo programador no arquivo routers.php. 
		*/
		$routes = Route::get_routes(); 

		/*
			TODO: 
				Implementar um try-catch caso o método não execute a ação; 
				Verificar se o array de rotas está vazio; 
				Caso ocorra um problema, a aplicação deve emitir um erro ~simpático~
		*/

		/*
			Recolendo a rota atual digitada pelo usuário. Exemplo: 

			http://www.exemplo.com.br/welcome

			A rota corrente é /welcome
		*/

		$current_route = self::get_current_route(); 

		/*
			Recupera a função anônima ou a string para invocação de método; 
			Se o tipo de $method for igual a string, isso implica em repartir a
			mensagem e executar o procedimento invocação de classe. Casocontrário, 
			basta invocar o método anônimo. 
		*/

		$method = $routes[$request_method][$current_route];

		try{
			if(gettype($method) == 'string')
  				self::pos_processing(self::run_reflection($method, $params)); 
			else
				self::pos_processing($method($params)); 
			
		}catch(\Exception $e){
			var_dump($e->getMessage()); 
		}
	}

	public function get_current_route(){
		// echo $_SERVER['DOCUMENT_ROOT']. '<br>'; 
		// echo $_SERVER['PHP_SELF']. '<br>'; 
		// die ($_SERVER['REQUEST_URI']); 

		/*
			TODO: 
				Tratar se o usuário da arquitetura adicionar a aplicação em pastas intermédiárias, ou seja, 
				pastas que não são a root; 
		*/

		$self     = $_SERVER['PHP_SELF']; 
		$uri      = $_SERVER['REQUEST_URI']; 


		/*
			/public/ é o limiar que divide a pasta root: 

			Exemplo da aplicação rodando na pasta root: 

			/public/index.php
			/adf/sdf/adfasf/adfasdf?df=sdf&sdfsadf=asdf

			Exemplo da aplicação rodando em uma pasta intermediária: 

			/ArquiteturaPHP/public/index.php
			/ArquiteturaPHP/adf/sdf/adfasf/adfasdf?sdf=asdf
		*/

		$threshold = 'public'; 

		$temp = explode($threshold, $self); 

		/*
			O que está à esquerda de temp deve ser retirado. 
		*/

		$temp = $temp[0]; 

		/*
			Se o resultado desse processamento for igual a 1 ou '/', significa que
			que não há pastas intermediárias. 
		*/

		// echo '<br>'. strlen($temp); 

		if(strlen($temp) != 1)
			$uri = substr($uri,strlen($temp)-1, strlen($uri)); 
		
		/*
			Retirando eventuais queries get; 
		*/

		$has_get_query = strpos($uri, '?'); 

		// var_dump($has_get_query);  

		if(!$has_get_query)
			return $uri;
		
		return substr($uri, 0, $has_get_query);   
	}

	private function get_object_by_namespace($controller_name){
		$space = $this->controllers_namespace . $controller_name;

		/*
			Tenta invocar uma classe através do namespace da mesma; 
		*/
		try{
			return new $space; 
		}catch(\Exception $e){
			return false;
		}

		return false; 
	}

	private function run_reflection($method, $params){
		$temp = explode('@', $method); 

		$class_name  = $temp[0]; 
		$method_name = $temp[1];  

		$object = self::get_object_by_namespace($class_name);

		$result = call_user_method($method_name, $object, $params); 

		return $result; 
	}

	private function pos_processing($method_result){
		switch( gettype($method_result) ){
			case 'string': 
				die($method_result); 
			break; 

			case 'array': 
				die(json_encode($method_result)); 
			break; 

			case 'object': 
				var_dump($method_result); 
			break; 
		}
	}
}