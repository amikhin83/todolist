<?php
	function __autoload($class_name) {
        $filename = strtolower($class_name) . '.php';
		$folders = ['classes','models','controllers'];
        foreach($folders as $folder) {
			$file = APP_DIR . $folder . '/' . $filename;
			if (file_exists($file)) {
				include ($file);
				return true;
			}
		}
		return false;
	}
