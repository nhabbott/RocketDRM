<?php 
	$rows = $conn->prepare("SELECT `subscribed` FROM `users` WHERE `steamid`=?");
	
	$rows->bindValue(1, $steamprofile[steamid]);
	$rows->execute();
	$obj = $rows->fetchObject();

	if ($obj->num_rows > 0) {
		// output data of each row
		while($obj = $obj->fetch_assoc()) {
			if($obj["subscribed"] == 0) {
				$output_subscription = "None";
			} else {
				$output_subscription = "Active";
			}
		}
	}
?>