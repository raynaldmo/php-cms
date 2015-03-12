<?php # main.php

/* 
 *  This is the main content module.
 *  This page is included by index.php.
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

// trigger_error('main', E_USER_NOTICE);

if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];

  if (Post::validatePostId($pid)) {
    $post = Post::getById($dbc, $pid);
  } else {
    // Just grab latest post
    $post = Post::getLastPost($dbc);
  }
} else {
  // Just grab latest post
  $post = Post::getLastPost($dbc);
}

// Display latest post on main content area
if ($post) {
    if ($logged_in) {
echo <<<DE
          <h2>{$post->post_title}
            <span class="post-action">&nbsp;
              <a href="./index.php?p=post&action=edit&pid=$post->post_id">
              Edit
              </a>
              <span style="color:#1293ee">|</span>
            </span>
            <span class=post-action>
              <a href = "#" id="post-delete" data-pid="$post->post_id"
                data-ptitle="$post->post_title">Delete</a>
            </span>
          </h2>;
DE;

    } else {
      echo "<h2>{$post->post_title}</h2>";
    }

    echo '<h5>' . date('F jS, Y', $post->post_ts) . '</h5>';
    echo "<div>{$post->post_text}</div>";

} else {
  echo '<h4><em>No posts<em></h4>';
}

?>
