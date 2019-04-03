<?php 
ob_start();
$obj = new PDO('mysql:host=localhost;dbname=banking','root','');

session_start();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = $obj->query("SELECT * FROM newaccount WHERE acc_no='$username'");
    $client = $query->fetch();
    $depositsql = $obj->query("SELECT *,sum(creditor) as creditor,sum(debitor) as debitor FROM depositor WHERE acc_no='$username'");
    $totalamt = $depositsql->fetch();
    $balance = @($totalamt['creditor']-$totalamt['debitor']);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Banking project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--        <meta name="description" content="Responsive HTML/HTML5 Templates">
        <meta name="keywords" content="responsive, html, html5, wordpress, templates, themes">-->
        <meta name="author" content="Satnam Malhotra">

        <!-- JS -->
        <!-- HTML5 Support for IE -->
<!--        [if lt IE 9]>
          <script src="js/html5shim.js"></script>
        <![endif]-->

        <!-- Stylesheets -->
        <link href="style/css/bootstrap.css" rel="stylesheet">
        <style>
        <?php include 'style/style.css'; ?>
        </style>
        <!-- Favicons -->
        <link rel="shortcut icon" href="img/favicon/favicon.ico">
        <script src="style/js/jquery.min.js"></script>
        <script src="style/js/bootstrap.js"></script>
    </head>

    <body>
        <div class="outer">
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <!--<a class="navbar-brand" href="#">Brand</a>-->
                  </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="index.php">Home</a>
                        </li>
                        <li><a href="otherdoc.php?about=1">About Us</a></li>
                        <li><a href="index.php?contactus=1">Contact Us</a></li>
                    </ul>
                  </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

            <header>
                <div class="container">
                    <img src="logo/banklogo.jpeg" width="100" height="80" style="float:left;margin-right:20px;margin-top:15px;border-radius:5px;"/>
                    <h1><a href="#">E-World Bank <span class="red">Ltd</span>.</a></h1>
                    <p>Available World Banking Services</p>
                </div>
            </header>

        <div class="container">
            <nav>
                <ul class="nav nav-pills">
                    <li class="active">
                        <?php if(isset($_SESSION['username'])) {?>
                        <a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Home</a>
                         <?php } elseif (isset($_SESSION['adminuser'])) {?>
                        <a href="adminpage.php"><span class="glyphicon glyphicon-home"></span> Home</a>
                        <?php } else { ?>
                        <a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a>
                        <?php } ?>
                    </li>
                    <li><a href="index.php?applyonline=1"><span class="glyphicon glyphicon-tower"></span> Apply Online</a></li>
                    <li><a href="index.php?banking=1"><span class="glyphicon glyphicon-folder-close"></span> Banking</a></li>
                    <li><a href="otherdoc.php?services=1"><span class="glyphicon glyphicon-search"></span> Services</a></li>
                    <li><a href="otherdoc.php?about=1"><span class="glyphicon glyphicon-shopping-cart"></span> Loan</a></li>
                     <?php if(isset($_SESSION['username'])) {?>
                    <li style="float:left;margin-left:25%;font-weight:bold;line-height:40px;">Current Amount: <?php echo number_format($balance,2); ?></li>
                     <?php } ?>
                    <li style="float:right;">
                        <?php if(isset($_SESSION['username'])) {?>
                        <a href="dashboard.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> LogOut</a>
                        <?php } elseif (isset($_SESSION['adminuser'])) {?>
                        <a href="adminpage.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> LogOut</a>
                        <?php } else { ?>
                        <a href="index.php?login=1"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        </div>
                