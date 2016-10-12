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
    echo "<a class=\"page-scroll\" href=\"?login\" onclick=\"document.getElementById('login').submit(); return false;\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i> Login</a>";
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
					
					require ('userinfo.php');
					
					require ('config.php');
	
					$sql = "INSERT INTO users (steamid, username, realname) VALUES ('$steamprofile[steamid]', '$steamprofile[personaname]', '$steamprofile[realname]') ON DUPLICATE KEY UPDATE username='$steamprofile[personaname]', realname='$steamprofile[realname]'";
							
					if ($mysql->query($sql) === TRUE) {
						header('Location: '.$steamauth['loginpage']);
					} else {
						echo "Error: " . $sql . "<br>" . $mysql->error;
					}	

					$mysql->close();
	
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
