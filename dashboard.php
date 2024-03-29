<?php
    ob_start();
    session_start();

    require("steamauth/steamauth.php");
    require("steamauth/userInfo.php");
    require("helpers/db.php");

    if(!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] == false) {
        header('Location: index.php?login');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Addon Tools">

    <title>Addon Tools</title>

    <!-- Favicon -->
    <link rel="icon" href="/favicon-32x32.ico" sizes="32x32">
    <link rel="icon" href="/favicon-16x16.ico" sizes="16x16">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/dashboard.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <if lt IE 9>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <endif>
</head>

<body>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Addon Tools</a>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="steamauth/logout.php">Logout</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>-->
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>-->
            </ul>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i id="bell" class="fa fa-bell" aria-hidden="true"></i></a>
                <div id="dropdown-menu" class="dropdown-menu" aria-labelledby="dropdown01">
                    <?php require_once('helpers/notify.php'); Notifications::getNotifications();?>
                </div>
            </li>
            <input id="search" class="form-control mr-sm-2" type="text" placeholder="Steam64ID, IP, or PPTID">
        </div>
    </nav>

    <h2>Servers Using GRide</h1>
    <div id="servers_table">
        <table class="table table-inverse">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Server Name</th>
                    <th>Server IP</th>
                    <th>Customer</th>
                    <th>PayPal Transaction ID</th>
                    <th>Last Ping</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dashboard.js"></script>
</body>
</html>