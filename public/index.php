<?php 
require (__DIR__.'/../vendor/autoload.php');

use App\Kernel\Route; 

Route::get('/', function(){
	echo "nada"; 
}); 