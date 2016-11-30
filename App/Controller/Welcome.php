<?php 
namespace App\Controller; 

use App\View\ViewBuilder; 

class Welcome{
	private $view = null;   
	
	public function __construct(){
		$this->view = ViewBuilder::getInstance(); 

		$this->view
			 ->set_footer('layout.footer')
			 ->set_header('layout.header')
			 ->set_head('layout.head'); 
	}

	public function index($params){
		return $this->view
			->add_js_files(['js/teste.js'])
			->add_css_files(['css/teste.css'])
			->set_page('welcome.page')
			->render(); 
	}
}