<?php 
use App\Kernel\Route; 

/*
	Este local é reservado para a declaração de quais rotas o sistema deve obedecer. 

	Exemplo de uso: 

	Route::get('/welcome', function($params){
		return "Olá mundo"
	}); 
	
	Saída esperada no navegador 'Olá mundo'; 


	Ou

	Route::post('/new_user', function($params){
		return ['status' => 'registrado com sucesso']; 
	}); 

	Saída esperada no navegador {"status" : "registrado com sucesso"}

	OBS: 
	Por convenção, os tipos de dados 'string' são empacotados como reponse normal html. 
	Os tipos 'array' são empacotados em formato json.
*/

Route::get('/', function($params){
	return $params; 
}); 

Route::get('/welcome', 'Welcome@index'); 