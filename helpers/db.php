<?php
	define("user", "xxlmm13xx"); // DB Username
	define("pass", "BW5gu2NMCh"); // DB Password
	define("db", "xxlmm13xx_tracker"); // DB to use
	define("host", "xxlmm13xxgaming.com"); // DB Host
	
	$conn = new PDO('mysql:host='.host.';dbname='.db.';charset=utf8', user, pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));