<?php
	Class controller_core {
		function input($var,$default = false) {
			if(isset($_POST[$var])) {
				return $_POST[$var];
			}
			return $default;
		}
		
		function is_admin() {
			return isset($_SESSION['is_admin']);
		}
	}
