<?php
	$conn = new PDO('mysql:host='.host.';dbname='.db.';charset=utf8', user, pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>