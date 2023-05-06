<?php
	Class controller_user Extends controller_core {
		private $args;
		
		function __construct($args)
		{
			$this->args = $args;
		}
		
		function login() {
			$csrf_token = $this->input('csrf_token');
			if($csrf_token && $csrf_token == $_SESSION['csrf_token']) {
				$login = $this->input('login','');
				if($login == '') {
					$template_data['errors'][] = "Введите логин";
				}

				$password = $this->input('password','');
				if($password == '') {
					$template_data['errors'][] = "Введите пароль";
				}
				
				if($login=='admin' && $password == '123') {
					$_SESSION['is_admin'] = true;
					$this->goto_home();
				} else if($login && $password) {
					$template_data['errors'][] = "Пользователь не найден";
				}
			}
			
			$template_data['csrf_token'] = $_SESSION['csrf_token'];
			
			$this->render('user_auth_page',$template_data);
		}
		
		function logout() {
			unset($_SESSION['is_admin']);
			$this->goto_home();
		}
		
		private function render($tempalte_name,$vars) {
			$vars['admin_mode'] = $this->is_admin();
			$template_file = APP_DIR.'views/'.$tempalte_name.".php";
			if(is_file($template_file)) {
				include($template_file);
			} else {
				echo "Template not found";
			}
		}
		
		function goto_home() {
			header("Location: ".APP_PATH);
			die();
		}
	}
