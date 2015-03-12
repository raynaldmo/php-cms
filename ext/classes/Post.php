<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/3/15
 * Time: 1:14 PM
 */

class Post {
  private $pid;     // post id
  private $fields;  // other record fields

  // initialize a Post object
  public function __construct() {
    $this->pid= null;
    $this->fields = array('user_id' => '', 'post_title' => '',
      'post_text' => '', 'post_date' => '', 'post_update' => '',

      // calculated fields
      'post_ts' => ''
    );
  }

  // override magic method to retrieve properties
  // advantage here is no need to have separate get_xxxx
  // methods to retrieve individual properties
  public function __get($field) {
    if ($field == 'post_id') {
      return $this->pid;
    }
    else {
      return $this->fields[$field];
    }
  }

  // override magic method to set properties
  // same advantage as for __get() and here we also do
  // some data validation
  public function __set($field, $value) {
    if (array_key_exists($field, $this->fields)) {
      $this->fields[$field] = $value;
    }
  }

  public static function validatePostId($post_id) {
    // TODO: Should do more validation such as range check on $post_id
    return filter_var($post_id, FILTER_VALIDATE_INT);
  }

  // return an object populated based on post id
  public static function getById($dbc, $pid) {
    $post = new Post();

    $query = sprintf('SELECT post_id, user_id, post_title, post_text,' .
    ' post_date, UNIX_TIMESTAMP(post_date) AS post_ts ' .
    'FROM posts WHERE post_id = %d', $pid);

    write_db_log($query);
    $res = mysqli_query($dbc, $query);

    if (mysqli_num_rows($res)) {
      $row = mysqli_fetch_assoc($res);
      $post->user_id = $row['user_id'];
      $post->post_title = $row['post_title'];
      $post->post_text = $row['post_text'];
      $post->post_date = $row['post_date'];
      $post->post_ts = $row['post_ts'];
      $post->pid = $pid;
    } else {
      $post = null;
    }

    mysqli_free_result($res);

    return $post;
  }

  public static function getLastPost($dbc) {
    $post = new Post();

    $query = sprintf('SELECT post_id, user_id, post_title, post_text,' .
      ' post_date, UNIX_TIMESTAMP(post_date) AS post_ts ' .
      'FROM posts ORDER BY post_date DESC LIMIT 1');

    write_db_log($query);
    $res = mysqli_query($dbc, $query);

    if (mysqli_num_rows($res)) {
      $row = mysqli_fetch_assoc($res);
      $post->user_id = $row['user_id'];
      $post->post_title = $row['post_title'];
      $post->post_text = $row['post_text'];
      $post->post_date = $row['post_date'];
      $post->post_ts = $row['post_ts'];
      $post->pid = $row['post_id'];
    }
    mysqli_free_result($res);

    return $post;
  }


  // Get number of posts by reverse chronological order
  public static function getByDate($dbc, $cnt) {

    $posts = null;

    $query = sprintf('SELECT post_id, user_id, post_title, post_text,' .
      ' post_date, UNIX_TIMESTAMP(post_date) AS post_ts ' .
      'FROM posts ORDER BY post_date DESC LIMIT %d', $cnt);

    write_db_log($query);
    $res = mysqli_query($dbc, $query);

    $num = mysqli_num_rows($res);
    if ($num) {
      $posts = array();

      for ($i=0; $i<$num; $i++) {
        $posts[] = mysqli_fetch_assoc($res);
      }
    }

    mysqli_free_result($res);
    return $posts;
  }

  // save post to database
  public function savePost($dbc, $user_id=0) {
    if ($this->pid) {
      $query = sprintf('UPDATE posts SET post_title = "%s", ' .
        'post_text = "%s" , post_date = "%s", post_update = NOW()' .
        'WHERE post_id = %d',
        mysqli_real_escape_string($dbc, $this->post_title),
        mysqli_real_escape_string($dbc, $this->post_text),
        mysqli_real_escape_string($dbc, $this->post_date),
        $this->pid
      );

      write_db_log($query);
      mysqli_query($dbc, $query);
    }
    else {
      $query = sprintf('INSERT INTO posts (user_id, post_title,' .
        'post_text, post_date, post_update)' .
        ' VALUES ("%d", "%s", "%s", NOW(),NOW() )',
        $user_id,
        mysqli_real_escape_string($dbc, $this->post_title),
        mysqli_real_escape_string($dbc, $this->post_text)
      );
      write_db_log($query);
      mysqli_query($dbc, $query);

      $this->pid = mysqli_insert_id($dbc);
    }
  }

  // delete post from database
  public static  function deletePost($dbc, $post_id) {
      $query = sprintf('DELETE from posts ' .
        'WHERE post_id = %d', $post_id);

      write_db_log($query);
      mysqli_query($dbc, $query);
  }

  // Return posts that match $search_str
  public static function getBySearch($dbc, $search_str) {

    $posts = null;
    $str = mysqli_real_escape_string($dbc, $search_str);

    $str = "('\"$str\"' in boolean mode)";

    $query = sprintf('SELECT post_id, user_id, post_title, post_text,' .
      ' post_date, UNIX_TIMESTAMP(post_date) AS post_ts ' .
      'FROM posts where match(post_title,post_text) against %s',
      $str);

    write_db_log($query);
    $res = mysqli_query($dbc, $query);

    $num = mysqli_num_rows($res);
    if ($num) {
      $posts = array();

      for ($i=0; $i<$num; $i++) {
        $posts[] = mysqli_fetch_assoc($res);
      }
    }

    mysqli_free_result($res);
    return $posts;
  }


} 