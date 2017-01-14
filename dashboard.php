<?php
  require_once("helpers/get_subscribed.php");
  require("steamauth/steamauth.php");
  require("steamauth/userinfo.php");
  require("helpers/db.php");
  
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
    <meta name="author" content="RocketDRM">

    <title>Rocket DRM &middot Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700" />

    <!-- Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <if lt IE 9>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <endif>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Login Form -->
    <form id=\"login\" action=\"?login\" method=\"post\"></form>

   <div id="header">
		<div id="header-user">
			<?php if(CheckAdmin($steamprofile['personaname'])) {echo "<p style=\"color: rgb(46,204,113);\">$steamprofile['personaname']</p>";}else{echo $steamprofile['personaname'];} ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/grayscale.js"></script>

    <!-- Modernizr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

</body>
	
	<!-- JQuery / Javascript -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</html>
