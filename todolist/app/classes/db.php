<?php
class DB {

	private $db_name = CFG_DB_NAME;
	private $db_user = CFG_DB_USER;
	private $db_pass = CFG_DB_PASS;
	private $db_host = CFG_DB_HOST;

	private static $instance;

	public function __construct() {
		try {
			$this->db = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name.'', $this->db_user, $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		} catch (PDOException $e) {
			echo "DB ERROR";
			die();
		}
	}
	public function __destruct(){
      $this->db = null;
    }	

	public static function get_instance() {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function lastInsertId() {
		return 	$this->db->lastInsertId(); 
	}

	/*
	*	$sql - запрос
	*	$data - данные для подстановки в запрос
	*	$fetch - нужен результат
	*	$fetch_one - нужна только перваая запись
	*/
	public function query($sql, $data=[], $fetch = false, $fetch_one = false) {
		$query = $this->db->prepare($sql);
		$result = $query->execute($data);
		$this->err = $query->errorInfo();
		if(!is_null($this->err[1])) { 			throw new Exception($this->err[2]);		}
		if($fetch) {
			$all = $query->fetchAll(PDO::FETCH_ASSOC);
			if($fetch_one) {
				return isset($all[0])?$all[0]:false;	
			} else {
				return $all;
			}
		} else {
			return $query;
		}
	}
}
