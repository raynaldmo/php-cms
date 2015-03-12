<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/4/15
 * Time: 6:33 PM
 */

// Redirect if this page was accessed directly:
if (!defined('BASE_URL')) {

  // Need the BASE_URL, defined in the config file:
  require('lib/config.php');

  // Redirect to the index page:
  $url = BASE_URL . 'index.php';
  header ("Location: $url");
  exit;

}

require_once(DB);
require_once 'classes/Post.php';

echo '<h3>Post Archives</h3>';

// Display all posts in abbreviated form
// purposely use ridiculously big number
if ($posts = Post::getByDate($dbc, 100000)) {
  foreach ($posts as $post) {
    $title = $post['post_title'];
    $post_id = $post['post_id'];
    echo "<h4>$title</h4>";
    echo '<h5>' . date('F jS, Y', $post['post_ts']) . '</h5>';
    echo '<div>' . substr($post['post_text'],0,128) . '...</div>';
    echo '<p><a href="' . 'index.php?p=main&pid=' .
      $post_id . '">' . 'Read More' . '</a></p><br>';
  }
} else {
  echo '<h4><em>No posts<em></h4>';
}

?>
