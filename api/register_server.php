<?php
require('../helpers/db.php');
//Check if the customer is already in db, if so make new db entry for server and update others to reflect instances

date_default_timezone_set('UTC');

$servern = $_POST['name'];
$serverp = $_POST['ip'];
$customer = $_POST['sid'];
$tid = "";
$ping = date("Y-m-d H:i:s");

//**************************
// Get GmodStore Data (PTID)
//**************************

$scriptid = 2361;
$api_key = '254bbc439a6fc053455823a6d476cc16';

$url = 'https://gmodstore.com/api/scripts/purchases/'.$scriptid.'?api_key='.$api_key;
$agent = "Mozilla/5.0 (compatible; AddonTools/1.0; +https://panel.xxlmm13xxgaming.com)";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

if(!$response = curl_exec($ch))
	echo curl_error($ch);

curl_close($ch);

$purchases = json_decode($response, true);

foreach($purchases as $purchase) {
    if ($purchase['user_id'] == $customer)
        $tid = $purchase['transaction_id'];
        $revoked = ($purchase['purchase_revoked'] == 0 ? true : false);
}

//************************
// Start looking at our DB
//************************
$noaccess = "6e6f2061626d246a70"; //no access; 4534114563 (XOR)

if (!$tid == null && !$revoked == null)
    echo $noaccess; 
    exit;

/*$exempt = Array('192.168.1.21'); //For user who want use on multiple servers (by ip)

$select = $conn->prepare("SELECT * FROM `servers` WHERE `customer`=:customer");
$conn->quote($customer);
$select->bindParam(':customer', $customer, PDO::PARAM_STR);
$select->execute();

$sobj = $select->fetchAll(PDO::FETCH_ASSOC);

foreach($sobj as $row => $link) {
    if ($link['customer'] == $customer && $revoked) {
        echo $noaccess;
        exit;
    } elseif ($link['customer'] == $customer && !$revoked && $link['instances'] > 1 && !in_array($link['ip'], $exempt)) {
        echo $noaccess;
        exit;
    } elseif ($link['customer'] == $customer && !$revoked && $link['instances'] == )
}*/

$insert = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `instances`, `last_ping`, `revoked`) VALUES (?, ?, ?, ?, ?, ?, ?)");
$conn->quote($servern);
$conn->quote($serverp);
$conn->quote($customer);
$conn->quote($tid);
$insert->bindParam(1, $servern, PDO::PARAM_STR);
$insert->bindParam(2, $serverp, PDO::PARAM_STR);
$insert->bindParam(3, $customer, PDO::PARAM_STR);
$insert->bindParam(4, $tid, PDO::PARAM_STR);
$insert->bindParam(5, $servern, PDO::PARAM_INT); //instances
$insert->bindParam(6, $ping, PDO::PARAM_STR);
$insert->bindParam(7, $revoked, PDO::PARAM_BOOL);