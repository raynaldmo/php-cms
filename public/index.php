<?php # index.php

/* 
 *  This is the main page.
 *  This page includes the configuration file, 
 *  the templates, and any content-specific modules.
 */

// Require the configuration file before any PHP code:
require_once('../ext/lib/config.php');


// Validate what page to show:
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} elseif (isset($_POST['p'])) { // Forms
    $p = $_POST['p'];
} else {
    $p = NULL;
}

// Determine what page to display:
switch ($p) {
    case 'main':
      $page = 'main.php';
      $page_title = 'Welcome';
      break;

    case 'about':
        $page = 'about.php';
        $page_title = 'About This Site';
        break;
    
    case 'contact':
        $page = 'contact.php';
        $page_title = 'Contact Us';
        break;

    case 'login':
      $page = 'login.php';
      $page_title = 'Login';
      break;

    case 'register':
      $page = 'register.php';
      $page_title = 'Register';
      break;

    case 'search':
        $page = 'search.php';
        $page_title = 'Search Results';
        break;

    case 'thank_you':
      $page = 'thank_you.php';
      $page_title = 'Thank You';
      break;

    case 'verr':
      $page = 'verr.php';
      $page_title = 'Account Activation Error';
      break;

    case 'vok':
      $page = 'vok.php';
      $page_title = 'Account Activation';
      break;


    case 'vact':
      $page = 'vact.php';
      $page_title = 'Account Activation';
      break;

    case 'post':
      $page = 'post.php';
      $page_title = 'Add/Edit Post';
    break;

    case 'archives':
      $page = 'archives.php';
      $page_title = 'Post Archives';
    break;

    default:
        $page = 'main.php';
        $page_title = 'Welcome';
        break;
        
} // End of main switch.

// Make sure the file exists:
if (!file_exists('modules/' . $page)) {
    $page = 'main.php';
    $page_title = 'Site Home Page';
}

require('lib/header.php');
require('lib/sidebar.php');

// Show any page specific messages here
if (isset($_GET['action']) && $_GET['action'] == 'login') {
  $username = '';
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }
  echo "<p><strong><em>Welcome $username</em></strong>";
}

// Include the content-specific module:
// $page is determined from the above switch.
require('modules/' . $page);

require('lib/footer.php');

?>