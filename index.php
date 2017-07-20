<?php
    require("steamauth/steamauth.php");

    if(!isset($_SESSION['steamid'])) {
        steamlogin();
    } else if(isset($_SESSION['steamid'])) {
        echo '<a class="page-scroll" href="dashboard.php" >Dashboard</a>';
    }
?>
