<?php
    session_start();
    unset($_SESSION['steam_steamid']);
    unset($_SESSION['steam_personaname']);
    unset($_SESSION['steam_avatar']);
    unset($_SESSION['steam_avatarmedium']);
    unset($_SESSION['steam_avatarfull']);
    unset($_SESSION['steam_realname']);
    unset($_SESSION['isadmin']);
    unset($_SESSION['steamid']);
    session_destroy();
    header('Location: ../index.php');
?>