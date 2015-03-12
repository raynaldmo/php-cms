<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/3/15
 * Time: 11:56 AM
 */

// CRUD functionality for posts to database

if (!isset($_SESSION)) {
  session_start();
}

require_once('../ext/lib/config.php');
require(DB);
require 'classes/Post.php';

//########################################################################
// NOTE!! : All echo/print output in this file will be sent
// as AJAX response (see post.js)
//#########################################################################

if (isset($_POST['submitted']) ) {
  $post_title = $_POST['post_title'];
  $post_text = $_POST['post_text'];
  $user_id = $_SESSION['userId'];

  // Debug
  // trigger_error('add post', E_USER_NOTICE);

  // NOTE!!! $success_msg and $err_msg are AJAX responses back to the browser.
  // Do not change these strings unless the appropriate code change
  // is made in add_post.js
  $success_msg = '<span style="color: green;font-size: 1.2em">
  <b><em>Post saved</em></b><span>';

  $err_msg = "<span style='color:orangered;font-size: 1.2em'>
            <b><em>Failed to save post</em></b><span>";

  if ( !empty($post_title) and !empty($post_text) ) {

    $allowed_tags = '<h1><h2><h3><h4><p><span><i><em><b><strong><br>';

    // Assume post id of zero is invalid
    if (isset($_POST['post_id']) && ! $_POST['post_id']) {
      // Saving a brand new post
      $post = new Post();
      $post->post_title = strip_tags($_POST['post_title'], $allowed_tags);
      $post->post_text = strip_tags($_POST['post_text'], $allowed_tags);
      $post->savePost($dbc, $user_id);

      exit($success_msg);
    }

    if (isset($_POST['post_id']) && $_POST['post_id']) {
      // Updating existing post
      $post_id = $_POST['post_id'];

      if (Post::validatePostId($post_id)) {
        $post = Post::getById($dbc, $post_id);

        if ($post) {
          $post->post_title = strip_tags($_POST['post_title'],$allowed_tags);
          $post->post_text = strip_tags($_POST['post_text'], $allowed_tags);
          $post->savePost($dbc);
          exit($success_msg);
        }
      }
    }
  }

  // Debug
  trigger_error('process post', E_USER_NOTICE);
  echo $err_msg;

}

// Handle post deletion
if (isset($_POST['action']) && ($_POST['action'] == 'post_delete') ) {
  $post_title = $_POST['post_title'];
  $post_id = $_POST['post_id'];

  if (Post::validatePostId($post_id)) {
    Post::deletePost($dbc, $post_id);
    echo '<span>Post deleted ok</span>';
  }

}

// Handle post editing
if (isset($_POST['action']) && ($_POST['action'] == 'post_edit') ) {
  $post_id = $_POST['post_id'];

  if (Post::validatePostId($post_id)) {
    $post = Post::getById($dbc, $post_id);

    if ($post) {
      // TODO: Could use JsonSerializable class to json_encode() post object
      $res = array('status' => 'success',
        'data' => array($post->post_id, $post->user_id, $post->post_title,
          $post->post_text, $post->post_date, $post->post_ts) );
    } else {
      $res = array('status' => 'error', 'data' => '');
    }

    // AJAX response
    header('Content-Type: application/json');
    echo json_encode($res);
  }
}

