<?php
require('db.php');

$search = $_GET['term'];

if (isset($search)) {
    $bneed = false;

    if (filter_var($search, FILTER_VALIDATE_IP)) {
        $sql = $conn->prepare("SELECT * FROM `servers` WHERE `ip`=:val");
        $bneed = true;
    } elseif (preg_match("/[0-9]+/", $search)) {
        $sql = $conn->prepare("SELECT * FROM `servers` WHERE `customer`=:val");
        $bneed = true;
    } elseif (preg_match("/[a-zA-Z]+ \d/", $search)) { //Needs fixing
        $sql = $conn->prepare("SELECT * FROM `servers` WHERE `tid`=:val");
        $bneed = true;
    } else {
        $sql = $conn->prepare("SELECT * FROM `servers`");
        $bneed = false;
    }

    if ($bneed == true) {
        $conn->quote($search);
        $sql->bindParam(':val', $search, PDO::PARAM_STR);
        $sql->execute();
    } else {
        $sql->execute();
    }

    $res = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row => $link) {
        if ($link['tid'] == "Manual Transaction") {
            $tlink = '   <td>'.$link['tid'].'</td>';
        } else {
            $tlink = '   <td><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id='.$link['tid'].'">'.$link['tid'].'</a></td>';
        }

        if ($link['revoked'] == 1) {
            $rbtn = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"CallActions('ur');\">Unrevoke</button>";
        } else {
            $rbtn = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"CallActions('r');\">Revoke</button>";
        }

        if ($link['banned'] == 1) {
            $bbtn = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"CallActions('ub');\">Unban</button>";
        } else {
            $bbtn = "<button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"CallActions('b')\";>Ban</button>";
        }

        $num = $num + 1;
        echo'<tr>';
        echo'   <th scope="row">'.$num.'</th>';
        echo'   <td>'.$link['name'].'</td>';
        echo'   <td><a href="steam://connect/'.$link['ip'].'" title="Connect to Server">'.$link['ip'].'</a></td>';
        echo'   <td><a href="http://steamcommunity.com/profiles/'.$link['customer'].'" title="Goto Steam Profile">'.$link['customer'].'</a></td>';
        echo    $tlink;
        echo'   <td>'.$link['last_ping'].'</td>';
        echo'   <td>'.$rbtn.'  '.$bbtn.'</td>';
        echo'</tr>';
    }
}