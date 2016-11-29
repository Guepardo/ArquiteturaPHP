<?php 
define('DS', DIRECTORY_SEPARATOR); 

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
	Intancia a classe core e invoca o método para lidar com as requests
*/
$core = new Core(); 
echo $core->get_current_route(); 