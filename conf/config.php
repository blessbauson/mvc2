<?php 
	//define application constants
	define("APP_ROOT", str_replace("/index.php", "", $_SERVER['SCRIPT_NAME'])); 	//ex. /website
	define("WEB_ROOT", "http://".$_SERVER['SERVER_NAME'].APP_ROOT);					      //ex. http://localhost:8080/website
	define("BASE_PATH", dirname(__FILE__));

	//database parameters
	define("DB_HOST", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "root");
	define("DB_NAME", "sample");

	//mail parameters
	define("MAIL_NAME", "");
	define("MAIL_EMAIL", "");
	define("MAIL_HOST", "");
	define("MAIL_USERNAME", "");
	define("MAIL_PASSWORD", "");

	//PHP configs
	ini_set("include_path", get_include_path().PATH_SEPARATOR.APP_ROOT);
	ini_set("session.use_cookies",  1);
	ini_set("session.use_only_cookies",  1);
	ini_set("session.gc_maxlifetime",  9999999);
	ini_set("session.cookie_lifetime", 9999999);
	ini_set("session.auto_start", 1);
	
	session_start();
?>
