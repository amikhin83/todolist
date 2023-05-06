<?php
Class router {

	private $controller;
	private $method;
	private $args;

	function __construct($route_path) { 
		$this->args = explode("/",trim($route_path,"/"));
		if(isset($this->args[0]) && $this->args[0]!='') {
			$this->controller = 'controller_'.strtolower($this->args[0]);
		} else {
			$this->controller = 'controller_main';
		}
		if(isset($this->args[1])) {
			$this->method = strtolower($this->args[1]);
		} else {
			$this->method = 'index';
		}
	}

	function route() {
		$method = $this->method; 
		$controller = $this->controller;
		if (!is_callable([$controller, $method])) {
			$this->e404();
		}
		$runner = new $controller($this->args); 
		$runner->$method();
	}
	
	function e404() {
		header("HTTP/1.0 404 Not Found");
		echo "404 Not Found";
		die();
	}

}
