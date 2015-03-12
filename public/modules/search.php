<?php

/* 
 *  This is the search content module.
 *  This page is included by index.php.
 *  This page expects to receive $_GET['terms'].
 */

// Redirect if this page was accessed directly:
if (!defined('BASE_URL')) {

    // Need the BASE_URL, defined in the config file:
    require('../../ext/lib/config.php');
    
    // Redirect to the index page:
    $url = BASE_URL . 'index.php?p=search';
    
    // Pass along search terms?
    if (isset($_GET['terms'])) {
        $url .= '&terms=' . urlencode($_GET['terms']);
    }
    
    header ("Location: $url");
    exit;
    
} // End of defined() IF.



// Display the search results if the form
// has been submitted.
if (isset($_GET['terms']) && ($_GET['terms'] != 'Search...') ) {

  // Print a caption:
  echo '<h3>Search Results for <em>' . strip_tags($_GET['terms']) .
    '</em></h3>';

  if ($posts = Post::getBySearch($dbc, $_GET['terms'])) {
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
    echo '<h4><em>No Results<em></h4>';
  }

}