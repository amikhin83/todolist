<?php
	Class model_todo_items {

		private $db;
		private $page = 0;
		private $order_field = 'id';
		private $order_dir = 'desc';
		private $items_per_page = 3;
		private $admin_mode = false;
		private $message = "";
		
		function __construct($admin_mode) {
			$this->admin_mode = $admin_mode;
			$this->db = DB::get_instance();
		}
		
		function set_message($message) {
			$this->message = $message;
		}
		
		function set_page($page) {
			$this->page = $page;
		}

		function set_order_field($order_field) {
			$valid_fields = ['name','email','complete'];
			if(in_array($order_field,$valid_fields)) {
				if($this->order_field == $order_field) {
					$this->order_dir = ($this->order_dir == 'asc'?'desc':'asc');
				} else {
					$this->order_field = $order_field;
					$this->order_dir = 'asc';
				}
			}
				
		}

		function get_order_dir() {
			return $this->order_dir;
		}

		function set_order_dir($dir) {
			$this->order_dir = $dir;
		}

		function get_list() {
			$limit_start = $this->page * $this->items_per_page;

			$sql = "select * from todo_items order by ".$this->order_field." ".$this->order_dir." limit ".$limit_start.", ".$this->items_per_page;
			$items = $this->db->query($sql,[],true);
			$template_data['items'] = $this->prepare_values($items);
			
			$sql = "select count(*) as cnt from todo_items";
			$items_count = $this->db->query($sql,[],true,true);
			$items_count = $items_count['cnt'];
			if($items_count > $this->items_per_page) {
				$template_data['last_page'] = ceil($items_count/$this->items_per_page)-1;
			} else {
				$template_data['last_page'] = 0;
			}
		
			$template_data['current_page'] = $this->page;
			
			$template_data['order_field'] = $this->order_field;
			
			$template_data['order_dir'] = $this->order_dir;
			
			if($this->message) $template_data['message'] = $this->message;
			
			$this->render('todo_items_list',$template_data);
		}
		
		function prepare_values($tasks) {
			foreach($tasks as $key=>$task) {
				foreach($task as $t_key=>$t_value) {
					$task[$t_key] = str_replace(["\n","\r"],["<br>",""],htmlspecialchars($t_value));
				}
				$tasks[$key] = $task;
			}
			return $tasks;
		}
		
		function get_edit_item($task) {
			$template_data['page_title'] = "Добавить задачу";
			$template_data['task'] = $task;
			$this->render('todo_items_edit_item',$template_data);
		}
		
		function update_item($task) {
			$sql = "select id, name, email, task, edited from todo_items where id = :id";
			$exist_item = $this->db->query($sql,['id'=>$task['id']],true,true);
			if($exist_item !== false) {
				$edited = $exist_item['edited']==1 || 
						  $exist_item['task']!=$task['task'];
				$sql = "update todo_items set `task` = :task, 
											  `complete` = :complete, 
											  `edited` = :edited 
										   where id = :id";
				$sql_data = ['id'=>$task['id'],
							 'task'=>$task['task'],
							 'complete'=>$task['complete'],
							 'edited'=>$edited?1:0
							]; 
				$this->db->query($sql,$sql_data);
			} else {
				$this->create_item($task);
			}
		}
		function create_item($task) {
			$sql = "insert into todo_items (`email`,`name`,`task`,`complete`) values (:email, :name, :task, :complete)";
			$sql_data = ['email'=>$task['email'],'name'=>$task['name'],'task'=>$task['task'],'complete'=>$task['complete']];
			$this->db->query($sql,$sql_data);
			header('Location: '.APP_PATH);
			die();
		}

		private function render($tempalte_name,$vars) {
			$vars['admin_mode'] = $this->admin_mode;
			$template_file = APP_DIR.'views/'.$tempalte_name.".php";
			if(is_file($template_file)) {
				include($template_file);
			} else {
				echo "Template not found";
			}
		}
		
		function get_task($task_id) {
			$task = [
				'id' => 0,
				'name' => '',
				'email' => '',
				'task' => '',
				'complete' => 0
			];
			if($task_id>0) {
				$sql = "select * from todo_items where id = :id";
				$task_data = $this->db->query($sql,['id'=>$task_id],true,true);
				if($task_data!==false) {
					$task = $task_data;
				}
			}
			return $task;
		}
	}