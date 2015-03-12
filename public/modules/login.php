<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/25/15
 * Time: 10:18 AM
 */

// Redirect if this page was accessed directly:

if (!defined('BASE_URL')) {

  // Need the BASE_URL, defined in the config file:
  require('../../ext/lib/config.php');

  // Redirect to the index page:
  $url = BASE_URL . 'index.php';
  header ("Location: $url");
  exit;

}

header('Cache-control: private');

?>

<div id="status"></div>

<form id="login" method="post" action=''>
  <p class="form_element">
    <label for="username">Username</label>
  </p>
  <p class="form_element">
    <input type="text" name="username" id="username" size="30"
           value="<?php if (isset($_POST['username']))
             echo htmlspecialchars($_POST['username']); ?>"/>
  </p>
  <p class="form_element"><strong>OR</strong></p>

  <p class="form_element">
    <label for="email">Email Address</label>
  </p>

  <p class="form_element">
    <input type="text" name="email" id="email" size="30"
           value="<?php if (isset($_POST['email']))
             echo htmlspecialchars($_POST['email']); ?>"/>
  </p>

  <p class="form_element">
    <label for="password">Password</label>
  </p>
  <p class="form_element">
    <input type="password" name="password" id="password" size="30"
           value=""/>
  </p>

  <p class="form_element">
    <input type="submit" class="submit" value="Login"/>
  </p>

  <input type="hidden" name="submitted" value="1"/>

</form>
<br>
<br>
<div>
  <a href="#">Click here for forgotten Username or Password</a>
</div>