<?php
ob_start();
session_start();
require ('openid.php');
require ('config.php');

function logoutbutton() {
    echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"Logout\" type=\"submit\" /></form>"; //logout button
}

function steamlogin()
{
try {
	require("settings.php");
    $openid = new LightOpenID($steamauth['domainname']);

    $button['small'] = "small";
    $button['large_no'] = "large_noborder";
    $button['large'] = "large_border";
    $button = $button[$steamauth['buttonstyle']];

    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
    echo "<a class=\"page-scroll\" href=\"?login\" onclick=\"document.getElementById('login').submit(); return false;\" >Dashboard</a>";
}

     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) {
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);

                $_SESSION['steamid'] = $matches[1];
                 if (isset($steamauth['loginpage'])) {
					try {
    					require ('userinfo.php');
    					
    					require ('config.php');
    	
    					$sql = $conn->prepare("INSERT INTO `users` (`steamid`, `username`, `realname`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `username`=?, `realname`=?");
    					
                        $sql->bindValue(1, $steamprofile[steamid]);
                        $sql->bindValue(2, $steamprofile[personaname]);
                        $sql->bindValue(3, $steamprofile[realname]);
                        $sql->bindValue(4, $steamprofile[personaname]);
                        $sql->bindValue(5, $steamprofile[realname]);

                        $sql->execute();
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                 }
        } else {
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}

?>
