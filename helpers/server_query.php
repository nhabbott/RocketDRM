<?php
require('db.php');

$sql = $conn->prepare("SELECT * FROM `servers`");
$sql->execute();

$res = $sql->fetchAll(PDO::FETCH_ASSOC); 

foreach ($res as $row => $link) {
    if ($link['tid'] == "Manual Transaction") {
        $tlink = '   <td>'.$link['tid'].'</td>';
    } else {
        $tlink = '   <td><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id='.$link['tid'].'">'.$link['tid'].'</a></td>';
    }

    if ($link['revoked'] == 1) {
        $rbtn = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"CallActions('ur', '".$link['customer']."');\">Unrevoke</button>";
    } else {
        $rbtn = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"CallActions('r', '".$link['customer']."');\">Revoke</button>";
    }

    if ($link['banned'] == 1) {
        $bbtn = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"CallActions('ub', '".$link['customer']."');\">Unban</button>";
    } else {
        $bbtn = "<button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"CallActions('b', '".$link['customer']."')\";>Ban</button>";
    }

    echo'<tr>';
    echo'   <th scope="row">'.$link['id'].'</th>';
    echo'   <td>'.$link['name'].'</td>';
    echo'   <td><a href="steam://connect/'.$link['ip'].'">'.$link['ip'].'</a></td>';
    echo'   <td id="customer"><a href="http://steamcommunity.com/profiles/'.$link['customer'].'">'.$link['customer'].'</a></td>';
    echo    $tlink;
    echo'   <td>'.$link['last_ping'].'</td>';
    echo'   <td>'.$rbtn.'  '.$bbtn.'</td>';
    echo'</tr>';
}