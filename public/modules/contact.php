<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/12/15
 * Time: 11:12 AM
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
<h4>Use this form to send us your comments or questions. All fields are
  required.</h4>
<div id="status"></div>

<form id="contact" method="post" action=''>
  <p class="form_element">
    <label for="name">Name</label>
  </p>
  <p class="form_element">
    <input type="text" name="name" id="name" size="30"
           value="<?php if (isset($_POST['name']))
             echo htmlspecialchars($_POST['name']); ?>"/>
  </p>

  <p class="form_element">
    <label for="email">Email</label>
  </p>

  <p class="form_element">
    <input type="text" name="email" id="email" size="30"
           value="<?php if (isset($_POST['email']))
             echo htmlspecialchars($_POST['email']); ?>"/>
  </p>

  <p class="form_element">
    <label for="email-again">Email Again</label>
  </p>

  <p class="form_element">
    <input type="text" name="email-again" id="email-again" size="30"
           value="<?php if (isset($_POST['email-again']))
             echo htmlspecialchars($_POST['email-again']); ?>"/>
  </p>

  <p class="form_element">
    <label for="comments">Comments</label>
  </p>

  <p class="form_element">
    <textarea id="comments" name="comments" rows="15" cols="65"></textarea>
  </p>

  <p class="form_element">
    <input type="submit" class="submit" value="Send"/>
  </p>

  <input type="hidden" name="submitted" value="1"/>

</form>