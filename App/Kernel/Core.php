<?php 
namespace App\Kernel; 

use App\Kernel\Route; 

class Core{
	public function handle_requests(){
		var_dump(Route::get_routes()); 
	}
}