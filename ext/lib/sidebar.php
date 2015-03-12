<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/2/15
 * Time: 5:44 PM
 */
?>

<div class="sidebar">
  <?php

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
  echo '<h3>Latest Posts</h3>';

  // Display latest n posts (abbreviated form) in sidebar
  if ($posts = Post::getByDate($dbc, 3)) {
    foreach ($posts as $post) {
      $title = $post['post_title'];
      $post_id = $post['post_id'];
      echo '<p><a href="' . 'index.php?p=main&pid=' .
        $post_id . '">' . $title . '</a></p>';
      echo '<h5>' . date('F jS, Y', $post['post_ts']) . '</h5>';

      // echo '<div>' . substr($post['post_text'],0,128) . '</div>';
    }
  } else {
    echo '<h4><em>No posts<em></h4>';
  }

  ?>

  <h3>Search</h3>
  <form method="get" action="./index.php?p=search" id="search_form">
    <p>
      <input type="hidden" name="p" value="search" />
      <input class="search" type="text" name="terms" value="Search..." />
      <input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="css/search.png"
             alt="Search" title="Search" />
    </p>
  </form>
  <br>

  <h4>Links</h4>
  <ul>
    <li><a href="./index.php?p=archives">Archives</a></li>
  </ul>
  <?php
    if ($logged_in) {
echo <<<D
      <h4>Admin</h4>
      <ul>
        <li><a href="./index.php?p=post">Add Post</a></li>
      </ul>
D;
    }
  ?>

</div> <!-- site content -->

<div id="content">