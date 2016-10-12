<?php
  require("steamauth/steamauth.php");
  require("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rocket DRM &middot Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-rocket"></i> <span class="light">Rocket</span> DRM
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                    <li>
                        <?php
                            if(!isset($_SESSION['steamid'])) {
                                steamlogin();
                            } else if(isset($_SESSION['steamid'])) {
                                echo "<a class=\"page-scroll\" href=\"/steamauth/logout.php\" ><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i> Logout</a>";
                            }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro intro-bg">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Rocket DRM</h1>
                        <p class="intro-text">The one-stop-shop to protect <br> your creations</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About Rocket DRM</h2>
                <p>Rocket DRM was founded on September 15, 2016 for one reason, not to make money, but to protect a developer's hard work from thieves.</p>
                <p>Not only do we protect Lua scripts but also PHP scripts, such as loading screens. We did this not for saying we have more features than other DRMs but because we wanted to provide more functionality for developers like you.</p>
                <p>Here at Rocket DRM, we are dedicated to providing the best user experiences for not only the developers but also the users of their scripts. To do this we have implemented "downtime checks" to keep API, computer, and internet outages from
                stopping legitimate customers from using the product they purchased.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="content-section text-center">
        <div class="team-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>The Rocket DRM Team</h2>
                    <?php
                        $json = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=C1DA6C202E560C79C9F80659706866A0&steamids=76561198075957195');
                        $parsed = json_decode($json);
                        foreach($parsed->response->players as $player) {
                            echo "<img class=\"profile-image\" src=\"" . $player->avatarfull . "\">";
                            echo "<h4 class=\"profile-image-text\">" . $player->personaname . "<h4>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Your Website 2016</p>
        </div>
    </footer>

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

</html>
