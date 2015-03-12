<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/24/15
 * Time: 6:48 PM
 */

// Errors are emailed here:
// $contact_email = 'test@example.com';

//--------------------------- FUNCTIONS ----------------------------------//
// Create the error handler
function error_handler($errno, $errstr, $errfile, $errline, $errcontext) {

  global $debug, $admin_path;

  $levels = array (
    E_WARNING =>  "Warning",
    E_NOTICE =>  "Notice",
    E_USER_ERROR =>  "User Error",
    E_USER_WARNING =>  "User Warning",
    E_USER_NOTICE =>  "User Notice",
    E_STRICT =>  "Strict warning",
    E_RECOVERABLE_ERROR =>  "Recoverable error",
    E_DEPRECATED =>  "Deprecated feature",
    E_USER_DEPRECATED =>  "Deprecated feature"
  );

  $message = date( "Y-m-d H:i:s - ");
  $message .= $levels[$errno] . ' ('. $errno . ')'. " : $errstr in $errfile,
  line $errline\n";
  $message .= 'Log to file ' . $admin_path . APPLOG . "\n\n";
  $message .= "Variables:\n";
  $message .= print_r( $errcontext, true ) . "\n\n";

  if ($debug) {
    echo '<pre>' . $message . "\n";
    debug_print_backtrace();
    echo '</pre><br />';

    // error_log( $message, 0);
    error_log( $message, 3,  $admin_path . APPLOG);

  } else {
    // error_log ($message, 1, $contact_email); // Send email.
    error_log( $message, 3,  $admin_path . APPLOG);

    $ok = array(E_NOTICE, E_USER_NOTICE, E_WARNING, E_USER_WARNING);
    if (! in_array($errno, $ok)) {
      die('<div style="color:orangered">&lt;&lt;A system error occurred.
        Try reloading the page.&gt;&gt;</div>');
    }
  }
}

//------------------------------- END FUNCTIONS ----------------------------//
// report all errors
error_reporting(E_ALL);

// Always log errors
ini_set('log_errors', '1');

// for development, $debug will be true and error messages will show up
// in browser. for deployment no error messages are sent to browser
$debug ? ini_set('display_errors', '1') :  ini_set('display_errors', '0');

// Use my error handler:
set_error_handler('error_handler');

// Test error handler
// $var = 1/0;
// trigger_error("Test error handler.\n", E_USER_WARNING);

