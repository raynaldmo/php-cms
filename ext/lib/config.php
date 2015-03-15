<?php # config.php

/*
 *  Configuration file does the following things:
 *  - Has site settings in one location.
 */

// set time zone to use date/time functions without warnings
date_default_timezone_set('America/Los_Angeles');

$root = $_SERVER['DOCUMENT_ROOT'];
$host = substr($_SERVER['HTTP_HOST'], 0, 5);

// Log file names
define ('APPLOG', '/app_log.txt');
define ('DBLOG', '/db_log.txt');

//------------------------- Database Query Logging -----------------------
// define group and record separator characters
define('GS', ':');
define('RS', "\n");

// record DB accesses
function write_db_log($message) {
  global $admin_path, $debug;

  $username = '';
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }
  $str = date('Ymd\THis') . GS. $username .
    GS . substr($message,0,256) . RS;

  if ($debug) {
    file_put_contents( $admin_path . DBLOG, $str, FILE_APPEND);
  } else {
    file_put_contents('php://stdout', $str);
  }

  /*
  $fp = fopen($admin_path . DBLOG, 'a');
  fwrite($fp, date('Ymd\THis') . GS. $username . GS .
    substr($message,0,256) . RS);
  fclose($fp);
  */

}

//----------------------- End Database Query Logging ---------------------

if (in_array($host, array('local', '127.0', '192.1'))) {
    // settings for development server
    $local = true;
    $local_root = $root . '/php-cms'; // /var/www/php-cms
    $admin_path = $local_root . '/ext/admin'; // i.e /var/www/php-cms/ext/admin

  $path = get_include_path() . PATH_SEPARATOR . $admin_path .
      PATH_SEPARATOR . $local_root . '/ext' .
      PATH_SEPARATOR . $local_root . '/public';

  set_include_path($path);

} else {
    // settings for Heroku deployment server
    $local = false;

    // $root is /app/public
    // $ext_path is /app/ext
    $ext_path = dirname($root) . '/ext';

    $path = get_include_path() . PATH_SEPARATOR . $ext_path .
      PATH_SEPARATOR . $ext_path . '/admin' .
      PATH_SEPARATOR . $root . '/lib' .
      PATH_SEPARATOR . $root . '/classes';

    set_include_path($path);
}

// Determine location of files and the URL of the site:
// Allow for development on different servers.
if ($local) {
    $debug = true;
    define('BASE_URI', $local_root);  // var/www/php-cms
    define('BASE_URL', 'http://192.168.0.252/php-cms/public/');
    define('DB', $local_root . '/ext/admin/db.php');

} else {
    $debug = false;
    define('BASE_URI', $root);
    define('BASE_URL', 'http://php5-cms.herokuapp.com/');
    define('DB', $ext_path . '/admin/db.php');
}

//------------------------------------------------------------------------

require 'lib/error.php';

