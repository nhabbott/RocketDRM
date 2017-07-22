<?php
require('db.php');

$action = $_GET['term'];
$customer = $_GET['customer'];

if ($action == "r" && isset($_GET['term']) && isset($_GET['customer'])) {
    $url = 'https://gmodstore.com/api/scripts/revokepurchase/'.$script.'?api_key='.$api_key.'&steam64='.$customer;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if(!$response = curl_exec($ch))
        echo curl_error($ch);

    curl_close($ch);

    # Decode the retrieved JSON into a PHP array
    $status = json_decode($response, true);

    if ($status['status'] == "success") {
        $sql = $conn->prepare("UPDATE `servers` SET `revoked`=? WHERE `customer`=?");
        $revoke = 1;
        $sql->bindParam(1, $revoke, PDO::PARAM_INT);
        $sql->bindParam(2, $customer, PDO::PARAM_STR);
        $sql->execute();
        echo "worked";
        exit;
    } else {
        echo "failed";
        exit;
    }
} elseif ($action == "ur" && isset($_GET['term']) && isset($_GET['customer'])) {
    $url = 'https://gmodstore.com/api/scripts/assignpurchase/'.$script.'?api_key='.$api_key.'&steam64='.$customer;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if(!$response = curl_exec($ch))
        echo curl_error($ch);

    curl_close($ch);

    # Decode the retrieved JSON into a PHP array
    $status = json_decode($response, true);

    if ($status['status'] == "success") {
        $sql = $conn->prepare("UPDATE `servers` SET `revoked`=? WHERE `customer`=?");
        $revoke = 0;
        $sql->bindParam(1, $revoke, PDO::PARAM_INT);
        $sql->bindParam(2, $customer, PDO::PARAM_STR);
        $sql->execute();
        echo "worked";
        exit;
    } else {
        echo "failed ur";
        exit;
    }
} elseif ($action == "b" && isset($_GET['term']) && isset($_GET['customer'])) {
    $sql = $conn->prepare("UPDATE `servers` SET `banned`=? WHERE `customer`=?");
    $banned = 1;
    $sql->bindParam(1, $banned, PDO::PARAM_INT);
    $sql->bindParam(2, $customer, PDO::PARAM_STR);
    $sql->execute();
    echo "worked";
    exit;
} elseif ($action == "ub" && isset($_GET['term']) && isset($_GET['customer'])) {
    $sql = $conn->prepare("UPDATE `servers` SET `banned`=? WHERE `customer`=?");
    $banned = 0;
    $sql->bindParam(1, $banned, PDO::PARAM_INT);
    $sql->bindParam(2, $customer, PDO::PARAM_STR);
    $sql->execute();
    echo "worked";
    exit;
} else {
    echo "you thought";
    exit;
}