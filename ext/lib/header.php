<?php # header.php
// This page begins the HTML header for the site.

session_start();

// Check for a $page_title value:
if (!isset($page_title)) { $page_title = 'Default Page Title'; }
$logged_in =
  (isset($_SESSION['access']) && $_SESSION['access']);
?>

<!DOCTYPE HTML>
<html>

<head>
  <title><?php echo $page_title; ?></title>
  <link rel="stylesheet" type="text/css" href="css/style.css" title="style"
      />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <h1><a href="./index.php"><em>MyHistory<span
                class="logo_colour">Notes</span></em></a></h1>
          <h2>Ramblings About World History</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <li><a href="./index.php">Home</a></li>
          <li><a href="./index.php?p=about">About</a></li>
          <li><a href="./index.php?p=contact">Contact</a></li>
          <?php
            /*
            // Disable login/registration until we support user comments
            if ($logged_in) {
              print '<li><a href="./logout.php">Logout</a></li>';
              print '<li><a href="#">My Account</a></li>';
            } else {
              print '<li><a href="./index.php?p=register">Register</a></li>';
              print '<li><a href="./index.php?p=login">Login</a></li>';
            }
            */
          ?>

        </ul>
      </div>
    </div>
    <div id="site_content">


	<!-- End of header. -->