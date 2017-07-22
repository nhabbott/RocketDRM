<?php
    ob_start();
    session_start();
    require("steamauth/steamauth.php");

    if(!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] == false) {
        steamlogin();
        ob_end_flush();
    } else if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true) {
        header("Location: dashboard.php");
        ob_end_flush();
    }
?>
