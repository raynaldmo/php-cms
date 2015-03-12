<?php # thank_you.php

/*
 *  Thank you page to be displayed after successful user registration
 */

// Redirect if this page was accessed directly:
if (!defined('BASE_URL')) {

  // Need the BASE_URL, defined in the config file:
  require('lib/config.php');

  // Redirect to the index page:
  $url = BASE_URL . 'index.php';
  header ("Location: $url");
  exit;

}

// Interesting that no need to call session_start() here
// 'cause it was called in process_register.php and
// we get to thank_you.php via register.js processing of AJAX request
// session_start();
header('Cache-control: private');

require(DB);
require 'classes/User.php';

$userId = $_SESSION['userId'];
$token = $_SESSION['regToken'];

$u = User::getById($dbc, $userId);

// TODO: if can't retrieve $u, trigger_error

$msg = '<p><strong>Thank you for registering.</strong></p>';

$msg .= '<p>Click on the link below to activate your account.<br><br>' .
  '<a href="' . BASE_URL. 'verify.php?uid=' . $u->userId . '&token=' . $token . '">' .
  BASE_URL. 'verify.php?uid=' . $u->userId . '&token=' . $token . '</a>
  </p>';
;

$show_link = true;
$email_link = false;

if ($show_link) {
  echo $msg;
}

if ($email_link) {

  $msg .= "<br><p>You can also copy and paste the link into your browser
    address bar (if clicking on the link doesn't work).";

  // formatted mail requires a MIME and Content-Type header
  $mime = array('MIME-Version: 1.0',
    'Content-Type: text/html; charset="iso-8859-1"');

  $headers = join("\n", $mime);

  if (@mail($u->email, 'Activate your new account', $msg, $headers)) {
    echo '<p><strong>Thank you for ' .
      'registering.</strong></p><p>You will be receiving an ' .
      'email shortly with instructions on activating your ' .
      'account.</p>';
  }
  else {
     echo '<p><strong>There was an ' .
      'error sending you the activation link.</strong></p> ' .
      '<p>Please contact the site administrator at <a href="' .
      'mailto:admin@example.com">admin@example.com</a> for ' .
      'assistance.</p>';
  }
}








