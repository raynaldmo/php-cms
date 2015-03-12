<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/25/15
 * Time: 7:49 PM
 */

if (!isset($_SESSION)) {
  session_start();
}

require_once('../ext/lib/config.php');
require(DB);
require 'lib/utilities.php';
require 'classes/User.php';

//########################################################################
// NOTE!! : All echo/print output in this file will be sent
// as AJAX response (see register.js)
//#########################################################################

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submitted'])) {
    // validate password
    $password1 = (isset($_POST['password1'])) ? $_POST['password1'] : '';
    $password2 = (isset($_POST['password2'])) ? $_POST['password2'] : '';
    $password = ($password1 && $password1 == $password2) ?
      sha1($password1) : '';

    $captcha = false;
    $sess_captcha = $_SESSION['captcha'];
    $post_captcha = $_POST['captcha'];

    if (isset($post_captcha) && isset($sess_captcha)) {
      if (strtoupper($post_captcha) == $sess_captcha) {
        $captcha = true;
      }
    }

    // trigger_error('process_register', E_USER_NOTICE);

    // add the record if all input validates
    if ($password &&
      $captcha &&
      User::validateUsername($_POST['username']) &&
      User::validateEmail($_POST['email'])) {

      // make sure the user doesn't already exist
      $user = User::getByUsername($dbc, $_POST['username']);
      if ($user->userId) {
        echo '<p><strong>Sorry, that ' .
          'account already exists.</strong></p> <p>Please try a ' .
          'different username.</p>';
      }
      else {
        // create an inactive user record
        $u = new User();
        $u->username = $_POST['username'];
        $u->password = $password;
        $u->email = $_POST['email'];
        $token = $u->setInactive($dbc);

        // NOTE!!! This is an AJAX response back to the browser.
        // Do not change the following line.
        // register.js looks for this message to declare successful user
        // registration
        echo '<p>Thank you for registering.</p>';

        // Store these so 'Thank You' page can use them
        $_SESSION['userId'] = $u->userId;
        $_SESSION['regToken'] = $token;

        // The following header() call *won't* work since all output from this
        // file is sent as AJAX response.
        // We instead redirect the browser to the the 'Thank You' page
        // in register.js

        // $url = BASE_URL . 'index.php?p=thank_you';
        // header ("Location: $url");
        // exit;
      }
    }
    // there was invalid data
    else {
      echo '<p><strong>You provided some ' .
        'invalid data.</strong></p> <p>Please fill in all fields ' .
        'correctly so we can register your user account.</p>';
    }

  }
}
