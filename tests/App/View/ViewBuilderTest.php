<?php 
use App\View\ViewBuilder; 

class ViewBuilderTest extends PHPUnit_Framework_TestCase{

	public function test_get_title(){

		$view = ViewBuilder::getInstance(); 

		$expected = "Corollarium"; 
		
		$this->assertEquals($expected, $view->get_title()); 
	}

	public function teste_get_title(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_title(); 
		$this->assertInternalType('string', $result); 
	}




	public function test_add_js_files(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->add_js_files(['js/teste.js']); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function test_get_js_files(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_js_files(); 
		$this->assertNotEmpty($result); 
	}




	public function test_add_css_files(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->add_css_files(['css/teste.css']); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function test_get_css_files(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_css_files(); 
		$this->assertNotEmpty($result); 
	}




	public function test_set_header(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->set_header('layout.header'); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function teste_get_header(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_header(); 
		$this->assertInternalType('string', $result); 
	}



	public function test_set_footer(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->set_footer('layout.footer'); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function teste_get_footer(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_footer(); 
		$this->assertInternalType('string', $result); 
	}



	public function test_set_head(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->set_head('layout.head'); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function teste_get_head(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_head(); 
		$this->assertInternalType('string', $result); 
	}



	public function test_set_page(){

		$view = ViewBuilder::getInstance(); 

		$result = $view->set_page('welcome.page'); 
		$this->assertInstanceOf(ViewBuilder::class, $result); 
	}

	public function teste_get_page(){
		$view = ViewBuilder::getInstance(); 

		$result = $view->get_page(); 
		$this->assertInternalType('string', $result); 
	}

}