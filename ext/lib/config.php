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

// write the provided message to the log file
function write_db_log($message) {
  global $admin_path;

  $username = '';
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  $fp = fopen($admin_path . DBLOG, 'a');
  fwrite($fp, date('Ymd\THis') . GS. $username . GS .
    substr($message,0,256) . RS);
  fclose($fp);
}

//----------------------- End Database Query Logging ---------------------

if (in_array($host, array('local', '127.0', '192.1'))) {
    // settings for development server
    $local = TRUE;
    $local_root = $root . '/php-cms'; // /var/www/php-cms
    $admin_path = $root . '/php-cms-admin'; // i.e /var/www/php-cms-admin

  $path = get_include_path() . PATH_SEPARATOR . $admin_path .
      PATH_SEPARATOR . $local_root . '/ext' .
      PATH_SEPARATOR . $local_root . '/public';

  set_include_path($path);

} else {
    // settings for deployment server
    $local = FALSE;
    // one level above document root
    $admin_path = dirname($root) . '/php-cms-admin';

    $path = get_include_path() . PATH_SEPARATOR . $admin_path .
      PATH_SEPARATOR . $root . '/ext' .
      PATH_SEPARATOR . $local_root . '/public';

    set_include_path($path);
}

// Determine location of files and the URL of the site:
// Allow for development on different servers.
if ($local) {
    $debug = TRUE;
    define('BASE_URI', '/var/www/php-cms');
    define('BASE_URL', 'http://192.168.0.252/php-cms/public/');
    define('DB', '/var/www/php-cms-admin/db.php');

} else {
    define('BASE_URI', '/path/to/live/html/folder/');
    define('BASE_URL', 'http://www.example.com/');
    define('DB', '/path/to/live/db.php');
}



//------------------------------------------------------------------------

/* 
 *  Most important setting!
 *  The $debug variable is used to set error management.
 *  To debug a specific page, add this to the index.php page:

if ($p == 'thismodule') $debug = TRUE;
require('./includes/config.inc.php');

 *  To debug the entire site, do

$debug = TRUE;

 *  before this next conditional.
 */

// Assume debugging is off. 
if (!isset($debug)) {
    $debug = FALSE;
}

$debug = false;

require 'lib/error.php';

