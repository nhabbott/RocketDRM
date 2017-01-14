<?php
	define("user", "root"); // DB Username
	define("pass", "root"); // DB Password
	define("db", "status"); // DB to use
	define("host", "127.0.0.1:8889"); // DB Host

	$conn = new PDO('mysql:host='.host.';dbname='.db.';charset=utf8', user, pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>