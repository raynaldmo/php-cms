<?php

if ($local) {
  // for local/development mysql server
  $url = parse_url('http://test:test@192.168.0.252/pcms');

} else {
  // for Heroku hosted mysql server
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
}

$db_server = $url["host"];
$db_user = $url["user"];
$db_pass = $url["pass"];
$db_name = substr($url["path"], 1);

// Make the connection:
$dbc = @mysqli_connect ($db_server, $db_user, $db_pass, $db_name) OR
  die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
