<!doctype html>
<html lang="ru" data-bs-theme="auto">
	<head>    
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Alex Mikhin">

		<title>ToDo - список задач<?=(isset($vars['page_title'])?' - '.$vars['page_title']:'');?></title>
		
		<link href="<?=APP_PATH;?>css/bootstrap.min.css" rel="stylesheet" >
		<link href="<?=APP_PATH;?>css/style.css" rel="stylesheet" >

		<script src="<?=APP_PATH;?>js/bootstrap.bundle.min.js"></script>
	</head>
	<body>
	   <nav class="navbar navbar-expand navbar-dark bg-dark">
		<div class="container-fluid">
		  <a class="navbar-brand" href="<?=APP_PATH;?>">ToDo - список задач</a>
		  <div class="collapse navbar-collapse" id="navbarsExample02">
			<ul class="navbar-nav me-auto">
			  <li class="nav-item">
				<a class="nav-link" aria-current="page" href="<?=APP_PATH.'main/edit_item/';?>">Добавить задачу</a>
			  </li>
			  <li class="nav-item">
				<?php if(isset($vars['admin_mode']) && $vars['admin_mode'] == true) { ?>
					<a class="nav-link" aria-current="page" href="<?=APP_PATH.'user/logout/';?>">Выход</a>
				<?php } else { ?>
					<a class="nav-link" aria-current="page" href="<?=APP_PATH.'user/login/';?>">Вход</a>
				<?php } ?>
			  </li>
			</ul>
		  </div>
		</div>
	  </nav>
	  <div class="container">
		<div class="row">
		  <div class="col">
