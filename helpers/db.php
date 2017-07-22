<?php
	define("user", "xxlmm13xx"); // DB Username
	define("pass", "BW5gu2NMCh"); // DB Password
	define("db", "xxlmm13xx_tracker"); // DB to use
	define("host", "xxlmm13xxgaming.com"); // DB Host

	$script = 2361;
	$api_key = "254bbc439a6fc053455823a6d476cc16";
	$agent = "Mozilla/5.0 (compatible; AddonTools/1.0; +https://panel.xxlmm13xxgaming.com)";
	
	$conn = new PDO('mysql:host='.host.';dbname='.db.';charset=utf8', user, pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));