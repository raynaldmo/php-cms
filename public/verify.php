<?php

require_once('../ext/lib/config.php');
require(DB);
require 'lib/utilities.php';
require 'classes/User.php';

// make sure a user id and activation token were received
if (!isset($_GET['uid']) || !isset($_GET['token'])) {
  trigger_error('Got bad uid or token', E_USER_NOTICE);

  $url = BASE_URL . 'index.php?p=verr';
  header ("Location: $url");
  exit;

}

// cast will force $_GET['uid'] to integer
$u = User::getById($dbc, (int)$_GET['uid']);

if ( ! $u->userId) {
  trigger_error('No user account for given uid', E_USER_NOTICE);

  $url = BASE_URL . 'index.php?p=verr';
  header ("Location: $url");
  exit;
}

if ($u->isActive) {
    trigger_error('User account has already been activated', E_USER_NOTICE);

    $url = BASE_URL . 'index.php?p=vact';
    header ("Location: $url");
    exit;
 }

// TODO: should I do anything to validate/sanitize $token
$token = $_GET['token'];

if ($u->setActive($dbc, $token)){
  $url = BASE_URL . 'index.php?p=vok';
  header ("Location: $url");
  exit;


}
else {
  trigger_error('Couldn\'t set user account active', E_USER_NOTICE);

  $url = BASE_URL . 'index.php?p=verr';
  header ("Location: $url");
  exit;
}
