<?php

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

<form id="post_add" method="post" action=''>
  <p class="form_element">
    <label for="post_title">Title</label>
  </p>
  <p class="form_element">
    <input type="text" name="post_title" id="post_title" size="30"
           value="<?php if (isset($_POST['post_title']))
             echo htmlspecialchars($_POST['post_title']); ?>"/>
  </p>

  <p class="form_element">
    <label for="post_text">Content</label>
  </p>

  <p class="form_element">
    <textarea id="post_text" name="post_text" rows="25" cols="72"></textarea>
  </p>

  <p class="form_element">
    <input type="submit" class="submit" value="Save"/>
    <input type="button" id="cancel" class="submit" value="Cancel"/>
  </p>

  <input type="hidden" id="post_id" name="post_id" value="0">
  <input type="hidden" name="submitted" value="1"/>

</form>

<?php
// ob_end_flush();
?>

