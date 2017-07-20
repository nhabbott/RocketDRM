<?php
    require("steamauth/steamauth.php");

    if(!isset($_SESSION['steamid'])) {
        steamlogin();
    } else if(isset($_SESSION['steamid'])) {
        header("Location: dashboard.php");
    }
?>
