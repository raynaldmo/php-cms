<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/27/15
 * Time: 9:09 PM
 */
session_start();

require('../ext/lib/config.php');

// Delete session cookie in user's browser
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}

// Delete session data on server
$_SESSION = array();
session_unset();
session_destroy();

// Redirect to the index page:
$url = BASE_URL . 'index.php';
header ("Location: $url");
exit;