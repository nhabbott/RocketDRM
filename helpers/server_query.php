<?php
require('db.php');

$sql = $conn->prepare("SELECT * FROM `servers`");
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