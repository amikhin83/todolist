<?php
	Class controller_main Extends controller_core {
		private $args;
		
		function __construct($args)
		{
			$this->args = $args;
		}
		
		function index() {
			$todo_items = new model_todo_items($this->is_admin());
			
			$page = isset($this->args[2])?(int)$this->args[2]-1:0;
			if($page) $todo_items->set_page($page);
			
			if (isset($_SESSION['order_field'])) {
				$todo_items->set_order_field($_SESSION['order_field']);
			}
			if (isset($_SESSION['order_dir'])) {
				$todo_items->set_order_dir($_SESSION['order_dir']);
			}
			
			$order_field = $this->input('order_field');
			if($order_field) {
				$todo_items->set_order_field($order_field);
				$_SESSION['order_field'] = $order_field;
				$_SESSION['order_dir'] = $todo_items->get_order_dir();
			} 
			if(isset($_SESSION['message'])) {
				$todo_items->set_message($_SESSION['message']);
				unset($_SESSION['message']);
			};
			
			$todo_items->get_list();
		}
		
		
		function edit_item() {
			$todo_items = new model_todo_items($this->is_admin());
			
			$edit_id = (int)$this->input('edit_id',0);
			if($edit_id>0 && !$this->is_admin()) {
				$this->goto_auth_page();
			}
			
			$task_id = $edit_id;
			$task = $todo_items->get_task($task_id);
			
			$task['csrf_token'] = $_SESSION['csrf_token'];
			$task['errors'] = [];
			
			$csrf_token = $this->input('csrf_token');
			if($csrf_token && $csrf_token == $_SESSION['csrf_token']) {
				$task['complete'] = $this->is_admin()?(int)$this->input('complete',0):0;
				$task['task'] = $this->input('task');
				$task['errors'] = [];
				if($task['id']==0) {
					$task['email'] = $this->input('email');
					$task['name'] = $this->input('name');
					if(!$task['email']) {
						$task['errors'][] = "Введите адрес электронной почты";
						} else if($task['email'] && !filter_var($task['email'], FILTER_VALIDATE_EMAIL)) {
						$task['errors'][] = "Введен некорректный адрес электронной почты";
						} else if(mb_strlen($task['email'])>128) {
						$task['errors'][] = "Длина адреса электронной почты не может быть более 128 символов";
					}
					if(!$task['name']) {
						$task['errors'][] = "Введите Ваше имя";
						} else if(mb_strlen($task['name'])>128) {
						$task['errors'][] = "Длина имени не может быть более 128 символов";
					}
				}
				
				if(!$task['task']) {
					$task['errors'][] = "Введите текст задачи";
				}
				
				if(count($task['errors'])==0) {
					if($task['id']>0) {
						$todo_items->update_item($task);
						$task['message'] = "Данные сохранены";
						} else {
						unset($_SESSION['order_field']);
						unset($_SESSION['order_dir']);
						$_SESSION['message'] = "Новая задача добавлена";
						$todo_items->create_item($task);
					}
				} 
			}
			$todo_items->get_edit_item($task);
		}
		
		function goto_auth_page() {
			header("Location: ".APP_PATH."/user/login/");
			die();
		}
	}
