<?php
require('../helpers/db.php');
require('../helpers/notify.php');
//Check if the customer is already in db, if so make new db entry for server and update others to reflect instances

date_default_timezone_set('UTC');

$servern = $_POST['name'];
$serverp = $_POST['ip'];
$customer = $_POST['sid'];
$tid = "";
$ping = date("Y-m-d H:i:s");

$noaccess = "sQHJAz3az4WePevw";
$yesaccess = "vZTFfrwGA7nfhGCL";

$insert = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `last_ping`) VALUES (?, ?, ?, ?, ?)");
$update = $conn->prepare("UPDATE `servers` SET `last_ping`=? WHERE `ip`=?");
$ban = $conn->prepare("INSERT INTO `servers` (`name`, `ip`, `customer`, `tid`, `last_ping`, `banned`) VALUES (?, ?, ?, ?, ?, ?)");
$revoke = $conn->prepare("UPDATE `servers` SET `revoked`=? WHERE `ip`=?");

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

            if ($robj == null) { echo $noaccess; exit; }

            foreach($robj as $row => $link) {
                $revoke->bindParam(1, $purchase['purchase_revoked'], PDO::PARAM_INT);
                $revoke->bindParam(2, $customer, PDO::PARAM_STR);
                $revoke->execute();
            }

            echo $noaccess;
            exit;
        }
    }
}

if (!$haspurchased) {
    echo $noaccess;
    exit;
}

//************************
// Start looking at our DB
//************************



$select = $conn->prepare("SELECT * FROM `servers` WHERE `ip`=?");
$conn->quote($serverp);
$select->bindParam(1, $serverp, PDO::PARAM_STR);
$select->execute();

$sobjexists = $select->fetchAll(PDO::FETCH_ASSOC);

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
        if ($link['ip'] == $serverp && $link['banned']) {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $serverp, PDO::PARAM_STR);
            $update->execute();
            echo $noaccess;
            exit;
        } elseif ($link['ip'] == $serverp && !$link['banned']) {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $serverp, PDO::PARAM_STR);
            $update->execute();
            echo $yesaccess;
            exit;
        } elseif ($link['ip'] != $serverp && !$link['banned'] && $sobjexists == null) {
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
            echo $noaccess;

            $from = "panel@xxlmm13xxgaming.com";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

            $message = '<html><body>';
            $message .= 'It looks like a server running {addon name} was automaticly banned';
            $message .= '<p>Server IP: <a href="steam://connect/'.$serverp.'">'.$serverp.'</a></p>';
            $message .= '<p><a href="https://www.gmodstore.com/users/view/'.$customer.'">GMS Account</a></p>';
            $message .= '<p>Steam: <a href="http://steamcommunity.com/profiles/'.$customer.'">'.$customer.'</a></p>';
            $message .= '</body></html>';

            mail("panel@xxlmm13xxgaming.com", "A server was automatically banned!", $message, $headers);
            Notifications::saveNotification('<div><a id="noti" class="dropdown-item">'.$serverp.' was banned'.'</a><a id="ip" class="hidden">'.$customer.'</a>');
            exit;
        } elseif ($link['ip'] != $serverp && !$link['banned'] && $sobjexists != null) {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $serverp, PDO::PARAM_STR);
            $update->execute();
            echo $yesaccess;
            exit;            
        } else {
            $conn->quote($customer);
            $update->bindParam(1, $ping, PDO::PARAM_STR);
            $update->bindParam(2, $serverp, PDO::PARAM_STR);
            $update->execute();
            echo $noaccess;
            exit;
        }
    }
}