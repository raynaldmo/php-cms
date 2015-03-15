<?php

if ($local) {
    // for local/development mysql server
  DEFINE ('DB_HOST', '192.168.0.252');
	DEFINE ('DB_NAME', 'pcms');
	DEFINE ('DB_USER', 'test');
	DEFINE ('DB_PASSWORD', 'test');
} else {
    // for Heroku hosted mysql server
  DEFINE ('DB_HOST', '');
	DEFINE ('DB_NAME', 'pcms');
	DEFINE ('DB_USER', '');
	DEFINE ('DB_PASSWORD', '');
}

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR
  die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
