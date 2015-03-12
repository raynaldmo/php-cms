<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/27/15
 * Time: 10:43 AM
 */

if (!isset($_SESSION)) {
  session_start();
}

require_once('../ext/lib/config.php');
require(DB);
require 'classes/User.php';

//########################################################################
// NOTE!! : All echo/print output in this file will be sent
// as AJAX response (see login.js)
//#########################################################################

if (isset($_POST['submitted']) ) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $pass = $_POST['password'];

  if ( (!empty($username) || !empty($email)) && !empty($pass)) {

    if (!empty($username)) {
      $user = (User::validateUsername($username)) ?
        User::getByUsername($dbc, $username) : new User();
    } else {
      $user = (User::validateEmail($email)) ?
        User::getByEmail($dbc, $email) : new User();
    }

    // retrieve user record
    if ($user->userId && $user->password == sha1($pass)) {

      // everything checks out so store values in session to track the
      // user and redirect to main page
      $_SESSION['access'] = TRUE;
      $_SESSION['userId'] = $user->userId;
      $_SESSION['username'] = $user->username;

      // Debug
      trigger_error('Login success', E_USER_NOTICE);

      // NOTE!!! This is an AJAX response back to the browser.
      // Do not change the following line.
      // login.js looks for this message to declare successful user
      // login
      echo '<p>Login success<p>';
    }
    else {
      // invalid user/email and/or password
      $_SESSION['access'] = FALSE;
      $_SESSION['username'] = null;

      trigger_error('Login failed', E_USER_NOTICE);

      echo "<span style='color:orangered'>Login failed. Please try again<span>";
    }
  }
  // missing credentials
  else {
    $_SESSION['access'] = FALSE;
    $_SESSION['username'] = null;

    trigger_error('Login failed', E_USER_NOTICE);

    echo "<span style='color:orangered'>Login failed. Please try again<span>";
  }

}
