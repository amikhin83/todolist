<?php 
	session_start();
	
	if(!isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = md5(microtime());
	}

	DEFINE("APP_DIR",$_SERVER['DOCUMENT_ROOT']."/../app/");

	require APP_DIR.'config.php';
	require APP_DIR.'autoload.php';

	$route_path = isset($_GET['route'])?$_GET['route']:'';
	$router = new router($route_path);
	$router->route();
			   