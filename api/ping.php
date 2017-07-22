<?php
require('../helpers/db.php');
//Check if the customer is already in db, if so make new db entry for server and update others to reflect instances

date_default_timezone_set('UTC');

$servern = $_POST['name'];
$serverp = $_POST['ip'];
$customer = $_POST['sid'];
$tid = "";
$ping = date("Y-m-d H:i:s");

$noaccess = "bad";
$yesaccess = "good";

$insert = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `last_ping`) VALUES (?, ?, ?, ?, ?)");
$update = $conn->prepare("UPDATE `servers` SET `last_ping`=? WHERE `customer`=?");
$ban = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `last_ping`, `banned`) VALUES (?, ?, ?, ?, ?, ?)");
$revoke = $conn->prepare("UPDATE `servers` SET `revoked`=? WHERE `customer`=?");

//**************************
// Get GmodStore Data (PTID)
//**************************

$url = 'https://gmodstore.com/api/scripts/purchases/'.$script.'?api_key='.$api_key;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

if(!$response = curl_exec($ch))
	echo curl_error($ch);

curl_close($ch);

$purchases = json_decode($response, true);
$purchases = $purchases['purchases'];

$haspurchased = false;

foreach($purchases as $purchase) {
    if (isset($purchase['user_id']) && $purchase['user_id'] == $customer) {
        if ($purchase['transaction_id'] == null) {
            $tid = "Manual Transaction";
        } else {
            $tid = $purchase['transaction_id'];
        }
        $revoked = ($purchase['purchase_revoked'] == 0 ? false : true);
        $haspurchased = true;
        if ($revoked) {
            $select = $conn->prepare("SELECT * FROM `servers` WHERE `customer`=?");
            $conn->quote($customer);
            $select->bindParam(1, $customer, PDO::PARAM_STR);
            $select->execute();

            $robj = $select->fetchAll(PDO::FETCH_ASSOC);

            if ($robj == null) { echo $noaccess." revoked"; exit; }

            foreach($robj as $row => $link) {
                $revoke->bindParam(1, $purchase['purchase_revoked'], PDO::PARAM_INT);
                $revoke->bindParam(2, $customer, PDO::PARAM_STR);
                $revoke->execute();
            }

            echo $noaccess." revoked";
            exit;
        }
    }
}

if (!$haspurchased) {
    echo $noaccess." nopurchase";
    exit;
}

//************************
// Start looking at our DB
//************************

/*if ($tid == null && $revoked == null) {
    echo $noaccess." other"; 
    exit;
}*/

$select = $conn->prepare("SELECT * FROM `servers` WHERE `customer`=?");
$conn->quote($customer);
$select->bindParam(1, $customer, PDO::PARAM_STR);
$select->execute();

$sobj = $select->fetchAll(PDO::FETCH_ASSOC);

if ($sobj == null) {
    $conn->quote($servern);
    $conn->quote($serverp);
    $conn->quote($customer);
    $conn->quote($tid);
    $insert->bindParam(1, $servern, PDO::PARAM_STR);
    $insert->bindParam(2, $serverp, PDO::PARAM_STR);
    $insert->bindParam(3, $customer, PDO::PARAM_STR);
    $insert->bindParam(4, $tid, PDO::PARAM_STR);
    $insert->bindParam(5, $ping, PDO::PARAM_STR);
    $insert->execute();
    echo $yesaccess;
    exit;
    
} else if ($sobj != null) {
    foreach($sobj as $row => $link) {
        if ($link['ip'] == $serverp && !$link['banned']) {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $customer, PDO::PARAM_STR);
            $update->execute();
            echo $yesaccess;
            exit;
        } elseif ($link['ip'] != $serverp && !$link['banned']) {
            $conn->quote($servern);
            $conn->quote($serverp);
            $conn->quote($customer);
            $conn->quote($tid);
            $banned = 1;
            $ban->bindParam(1, $servern, PDO::PARAM_STR);
            $ban->bindParam(2, $serverp, PDO::PARAM_STR);
            $ban->bindParam(3, $customer, PDO::PARAM_STR);
            $ban->bindParam(4, $tid, PDO::PARAM_STR);
            $ban->bindParam(5, $ping, PDO::PARAM_STR);
            $ban->bindParam(6, $banned, PDO::PARAM_INT);
            $ban->execute();
            echo $noaccess." banned";
            //Log & ban server + email system
            exit;
        } else {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $customer, PDO::PARAM_STR);
            $update->execute();
            echo $noaccess." other";
            exit;
        }
    }
}