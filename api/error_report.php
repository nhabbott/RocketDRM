<?php

$servern = $_POST['name'];
$serverp = $_POST['ip'];
$customer = $_POST['sid'];
$error = $_POST['error'];

if (!empty($servern) && !empty($serverp) && !empty($customer) && !empty($error)) {
    $from = "panel@xxlmm13xxgaming.com";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $message = '<html><body>';
    $message .= 'It looks like a server was given a different responce other then "good" and "bad" running {addon name}!';
    $message .= '<p>Server IP: <a href="steam://connect/'.$serverp.'">'.$serverp.'</a></p>';
    $message .= '<p><a href="https://www.gmodstore.com/users/view/'.$customer.'">GMS Account</a></p>';
    $message .= '<p>Steam: <a href="http://steamcommunity.com/profiles/'.$customer.'">'.$customer.'</a></p>';
    $message .= '<p>Error: '.$error.'</p>';
    $message .= '</body></html>';

    mail("panel@xxlmm13xxgaming.com", "A server was given an error!", $message, $headers);
    exit;

}
