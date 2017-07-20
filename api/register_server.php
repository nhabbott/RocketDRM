<?php
require('../helpers/db.php');
//Check if the customer is already in db, if so make new db entry for server and update others to reflect instances

date_default_timezone_set('UTC');

$servern = $_POST['name'];
$serverp = $_POST['ip'];
$steamid = $_POST['sid'];
$customer = "";
$tid = "";
$ping = date("Y-m-d H:i:s");

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
    if ($purchase['user_id'] == $steamid) {
        $customer = $purchase['user_id'];
        $tid = $purchase['transaction_id'];
        $revoked = if($purchase['purchase_revoked'] == 0) { return true; } else { return false; };
    }
}

$exempt = Array('192.168.1.21'); //For user who want use on multiple servers (by ip)

$sql = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `instances`, `last_ping`, `revoked`) VALUES (?, ?, ?, ?, ?, ?, ?)");
