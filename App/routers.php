<?php 
use App\Kernel\Route; 

/*
	Este local é reservado para a declaração de quais rotas o sistema deve obedecer. 

	Exemplo de uso: 

	Route::get('/welcome', function($params){
		echo "Olá mundo"
	}); 

	Ou

	Route::post('/new_user', function($params){
		echo json_encode(['status' => 'registrado com sucesso']); 
	}); 
*/

	Route::get('/', function(){
		echo "nada"; 
	}); 