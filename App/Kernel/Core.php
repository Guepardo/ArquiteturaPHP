<?php 
namespace App\Kernel; 

use App\Kernel\Route; 
use App\Kernel\Request; 

class Core{
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

		try{
			//Recupera a rota via método do request e invoca a função anônima
			$method = $routes[$request_method][$current_route];
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

		$doc_root = $_SERVER['DOCUMENT_ROOT']; 
		$self     = $_SERVER['PHP_SELF']; 
		$uri      = $_SERVER['REQUEST_URI']; 


		/*
			/public/ é o limiar que divide a pasta root: 

			Exemplo da aplicação rodando na pasta root: 

			C:/xampp/htdocs
			/public/index.php
			/adf/sdf/adfasf/adfasdf?df=sdf&sdfsadf=asdf

			Exemplo da aplicação rodando em uma pasta intermediária: 

			C:/xampp/htdocs
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