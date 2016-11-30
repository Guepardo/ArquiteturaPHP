<?php 
namespace App\View; 

class ViewBuilder{
	private static $view_builder = null; 

	private $title; 

	private $css_paths = []; 
	private $js_paths  = []; 

	private $header   =  ''; 
	private $page     =  ''; 
	private $footer   =  ''; 
	private $head     =  ''; 

	private $params   = null; 
	public function __construct(){
		$this->title = 'Corollarium'; 
	}

	public static function getInstance(){
		if(self::$view_builder == null)
			return self::$view_builder = new ViewBuilder(); 
		else
			return self::$view_builder; 
	}




	public function add_js_files($array_paths){

		foreach($array_paths as $path)
			array_push($this->js_paths, $path); 

		return $this; 
	}

	public function get_js_files(){
		return $this->js_paths; 
	}



	public function add_css_files($array_paths){

		foreach($array_paths as $path)
			array_push($this->css_paths, $path); 

		return $this; 
	}

	public function get_css_files(){
		return $this->css_paths; 
	}





	public function set_title($title){
		$this->title = $title; 

		return $this; 
	}

	public function get_title(){
		return $this->title; 
	}




	public function set_header($relative_path){
		$this->header = str_replace('.',DS, $relative_path); 
		return $this; 
	}

	public function get_header(){
		ob_start(); 

		require(RESOURCE.$this->header.'.php'); 

		$result = ob_get_contents(); 
		ob_end_clean();
		return $result; 
	}



	public function set_page($relative_path){
		$this->page = str_replace('.',DS, $relative_path); 
		return $this; 
	}

	public function get_page(){
		ob_start(); 

		require(RESOURCE.$this->page.'.php'); 

		$result = ob_get_contents(); 
		ob_end_clean();
		return $result; 
	}




	public function set_footer($relative_path){
		$this->footer = str_replace('.',DS, $relative_path); 
		return $this; 
	}

	public function get_footer(){
		ob_start(); 

		require(RESOURCE.$this->footer.'.php'); 

		$result = ob_get_contents(); 
		ob_end_clean();
		return $result; 
	}



	public function set_head($relative_path){
		$this->head = str_replace('.',DS, $relative_path); 
		return $this;
	}

	public function get_head(){
		ob_start(); 

		require(RESOURCE.$this->head.'.php'); 

		$result = ob_get_contents(); 
		ob_end_clean();
		return $result; 
	}


	public function render($params=[]){
		  $this->params = $params; 
		  return self::get_page();
	}
}