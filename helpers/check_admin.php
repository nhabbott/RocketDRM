<?php
	require_once("db.php");

	function CheckAdmin($user){
		$stmt = $conn->prepare("SELECT `admin` FROM `users` WHERE `steamid`=?");
		$stmt->bindValue(1, $user);
		$stmt->execute();
		$obj = $stmt->fetchObject();

		if($obj->admin == true){
			return true;
		} else {
			return false;
		}
	}
?>