<?php
ob_start();
session_start();
require ('openid.php');

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
    					require ('userInfo.php');
    					
    					require ('helpers/db.php');
    	
    					$sql = $conn->prepare("SELECT * FROM `users` WHERE `steamid`=:steamid");
    					
                        $sql->bindParam(':steamid', $steamprofile['steamid'], PDO::PARAM_STR);

                        $sql->execute();
                        $obj = $sql->fetchObject();
                        
                        if($obj->admin){
						    $_SESSION['isadmin'] = true;
						    $_SESSION['user'] = $steamprofile['username'];
                            header("Location: dashboard.php");
                            exit;
					    } else {
						    $_SESSION['isadmin'] = false;
					    }
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
