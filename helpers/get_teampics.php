<?php
    $json = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=C1DA6C202E560C79C9F80659706866A0&steamids=76561198075957195,76561198113581050');
    $parsed = json_decode($json);
	$col_count = 0;
    
    foreach($parsed->response->players as $player) {
		if($col_count == 0) {
			echo "<div class=\"col-sm-4 col-md-3 col-sm-offset-3\">";
			$col_count = $col_count + 1;
		} else {
			echo "<div class=\"col-sm-4 col-md-3 col-sm-offset-0\">";
			$col_count = $col_count + 1;
		}
        echo "<img class=\"profile-image\" src=\"" . $player->avatarfull . "\" draggable=\"false\">";
        echo "<h4 class=\"profile-image-text\">" . $player->personaname . "<h4>";
        echo "</div>";
    }
?>