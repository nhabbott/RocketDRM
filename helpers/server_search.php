<?php
require('db.php');

$search = $_REQUEST['term'];

if (isset($search)) {
    if (filter_var($search, FILTER_VALIDATE_IP)) {
        $sql = $conn->prepare("SELECT * FROM `servers` WHERE `ip`=?");
    } elseif (preg_match("/[0-9]+/", $search)) {
        $conn->prepare("SELECT * FROM `servers` WHERE `customer`=?");
    } elseif (preg_match("/[a-zA-Z]+ \d/", $search)) {
        $conn->prepare("SELECT * FROM `servers` WHERE `tid`=?");
    } else {
        $conn->prepare("SELECT * FROM `servers`");
    }

    $conn->quote($search);
    $sql->bindValue(1, $search, PDO::PARAM_STR);
    $sql->execute();

    $res = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row => $link) {
        $num = $num + 1;
        echo'<tr>';
        echo'   <th scope="row">'.$num.'</th>';
        echo'   <td>'.$link['name'].'</td>';
        echo'   <td>'.$link['ip'].'</td>';
        echo'   <td>'.$link['customer'].'</td>';
        echo'   <td>'.$link['tid'].'</td>';
        echo'   <td>'.$link['instances'].'</td>';
        echo'   <td>'.$link['last_ping'].'</td>';
        echo'</tr>';
    }
}