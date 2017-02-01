<?php
/* CONFIG FILE */

// DATABASE INFO
define('DB_SERVER',		'localhost');
define('DB_DATABASE',	'xcloud_regedit');
define('DB_USER',		'xcld_rgdt');
define('DB_PASS',		'karz223945');

// GLOBAL VARS
define('LOCAL', 		$_SERVER['HTTP_HOST']);
define('PATH',			$_SERVER['REQUEST_URI']);
define('USER_IP',		$_SERVER['REMOTE_ADDR']);
define('ROOT_PATH',		$_SERVER['DOCUMENT_ROOT']);
define('TMP_PATH',		'/resources/assets/tmp/');

// ERROR
ini_set('display_errors', 	0);
ini_set('error_reporting', 	E_ALL);