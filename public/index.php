<?php 
define('DS'      , DIRECTORY_SEPARATOR); 

define('RESOURCE', __DIR__.DS.'..'.DS.'resource'.DS); 

/*
	Carrega o autoload gerado pelo composer. 
*/
require (__DIR__.DS.'..'.DS.'vendor'.DS.'autoload.php');

/*
	Invoca duas classes do Kernel para o start-up da aplicação. 
*/
use App\Kernel\Core; 
use App\Kernel\Route; 

/*
	Carrega as rotas do contexto da aplicação
*/
require(__DIR__.DS.'..'.DS.'app'.DS.'routers.php'); 


/*
	Instancia a classe core e invoca o método para lidar com as requests
*/
$core = new Core(); 
$core->handle_requests(); 