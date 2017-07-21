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

    $num = $num + 1;
    echo'<tr>';
    echo'   <th scope="row">'.$num.'</th>';
    echo'   <td>'.$link['name'].'</td>';
    echo'   <td><a href="steam://connect/'.$link['ip'].'">'.$link['ip'].'</a></td>';
    echo'   <td><a href="http://steamcommunity.com/profiles/'.$link['customer'].'">'.$link['customer'].'</a></td>';
    echo    $tlink;
    echo'   <td>'.$link['last_ping'].'</td>';
    echo'</tr>';
}