<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/26/15
 * Time: 8:52 PM
 */

/*
 *  Account verification/activation success page
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

$msg =  '<p><strong>Thank you ' .
  'for activating your account.</strong></p> <p>You may ' .
  'now <a href="index.php?p=login">login</a>.</p>';

print $msg;
