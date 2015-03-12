<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/26/15
 * Time: 8:48 PM
 */

/*
 *  Account verification/activation error page
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

$msg = '<p><strong>There was an ' .
  'error activating your account.</strong></p> ' .
  '<p>Please contact the site administrator at <a href="' .
  'mailto:admin@example.com">admin@example.com</a> for ' .
  'assistance.</p>';

print $msg;

?>