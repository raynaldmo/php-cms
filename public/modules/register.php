<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 2/25/15
 * Time: 4:32 PM
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

// No need to call session_start() since we don't need to access
/// session variables here.
// session_start();
header('Cache-control: private');

?>

<div id="status"></div>

<form id="register" class="form-validate" method="post" action=''>
  <p class="form_element">
    <label for="username">Username</label>
  </p>
  <p class="form_element">
    <input type="text" name="username" id="username" size="30"
           value="<?php if (isset($_POST['username']))
             echo htmlspecialchars($_POST['username']); ?>"/>
  </p>
  <p class="form_element">
    <label for="password1">Password</label>
  </p>
  <p class="form_element">
    <input type="password" name="password1" id="password1" size="30"
           value=""/>
  </p>
  <p class="form_element">
    <label for="password2">Password Again</label>

  </p>
  <p class="form_element">
    <input type="password" name="password2" id="password2" size="30"
           value=""/>
  </p>
  <p class="form_element">
    <label for="email">Email Address</label>
  </p>
  <p class="form_element">
    <input type="text" name="email" id="email" size="30"
           value="<?php if (isset($_POST['email']))
             echo htmlspecialchars($_POST['email']); ?>"/>
  </p>
  <p class="form_element">
    <label for="captcha">Enter word seen in this image</label>
  </p>
  <p class="form_element">
    <img src="img/captcha.php?nocache=<?php echo time(); ?>"
         alt="captcha image"/>
  </p>
  <p class="form_element">
    <input type="text" name="captcha" id="captcha" size="7"/>
  </p>
  <p class="form_element">
    <input type="submit" class="submit" value="Sign Up"/>
  </p>

  <input type="hidden" name="submitted" value="1"/>

</form>


