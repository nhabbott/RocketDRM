<?php
  require("steamauth/steamauth.php");
  require("steamauth/userinfo.php");
  require_once("helpers/get_subscribed.php");
  require("config.php");
  
  if(!isset($_SESSION['steamid'])) {
	header('Location: index.php?login');
	exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rocket DRM &middot Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Login Form -->
    <form id=\"login\" action=\"?login\" method=\"post\"></form>

   <div id="header">
		<div id="header-user">
			<?php echo $steamprofile['personaname']; ?>
			<?php echo '<img src="' . $steamprofile['avatarmedium'] . '"  id="header-user-image" draggable="false" >'; ?>
		</div>
   </div>
	
	<div id="dashboard-panel-container">
		<div id="dashboard-panel-header">
			USER INFORMATION
		</div>
		<div id="dashboard-panel-body">
			<b>Steam Name:</b> <?php echo $steamprofile['personaname']; ?><br>
			<b>SteamID64:</b> <?php echo $steamprofile['steamid']; ?><br>
			<b>Subscription:</b> <?php if ($output_subscription == "Active") {echo "<p style=\"text-color: green\">$output_subscription</p>";} else {echo "<p style=\"text-color: red\">$output_subscription</p>";} ?><br>
		</div>
	</div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/grayscale.js"></script>

    <!-- Modernizr -->
    <script src="vendor/modernizr-2.6.2.min.js"></script>

</body>
	
	<!-- JQuery / Javascript -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</html>
