<?php
error_reporting(0);
session_start();
$server="localhost";
$user="root";
$pass="";
$db="hackathon";
$con=mysqli_connect($server,$user,$pass,$db);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>llity- Shorten your URL</title>
      <!-- Google-Fonts -->
      <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-reset.css" rel="stylesheet">
      <!--Icon-fonts css-->
      <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="css/style.css" rel="stylesheet">
      <link href="css/style-responsive.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Spicy+Rice|Shadows+Into+Light|Baloo+Da+2|Bangers&display=swap" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   </head>
   <body>
      <!-- Aside Start-->
      <aside class="left-panel">
         <!-- brand -->
         <div class="logo">
            <a href="form.php" class="logo-expanded">
            <img src="img/single-logo.png" alt="logo">
            <span class="nav-label" style="text-transform: none;">llity</span>
            </a>
         </div>
         <!-- / brand -->
         <!-- Navbar Start -->
         <nav class="navigation">
            <ul class="list-unstyled">
               <li class="has-submenu"><a href="form.php"><i class="fa fa-code"></i> <span class="nav-label">Generate Short URL</span></a>
               </li>
               <?php
               if(!isset($_SESSION['key'])) {
               ?>
               <li class="has-submenu"><a href="login.php"><i class="fa fa-sign-in"></i> <span class="nav-label">Sign In</span></a>
               </li>
               <?php } ?>
               <?php
               if(isset($_SESSION['key'])) {
               ?>
               <li class="has-submenu"><a href="manager.php"><i class="fa fa-columns"></i> <span class="nav-label">Dashboard</span></a>
               </li>
               <li class="has-submenu"><a href="settings.php"><i class="fa fa-cogs"></i> <span class="nav-label">Account Settings</span></a>
               </li>
               <li class="has-submenu"><a href="logout.php"><i class="fa fa-sign-out"></i> <span class="nav-label">Sign Out</span></a>
               </li>
               <?php } ?>
            </ul>
         </nav>
      </aside>
      <!-- Aside Ends-->
      <!--Main Content Start -->
      <section class="content">
         <!-- Header -->
         <header class="top-head container-fluid">
            <button type="button" class="navbar-toggle pull-left">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <!-- Right navbar -->
            <!-- End right navbar -->
         </header>
         <!-- Header Ends -->