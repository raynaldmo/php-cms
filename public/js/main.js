/**
 * Created by raynald on 3/5/15.
 */

$(document).ready(function() {

  //-------------------- Handle post delete link -----------------/
  var $delete_link = $('#post-delete');

  function deletePostOk(html) {
    // Debug
    // console.log(html);

    if (/(Post deleted ok)/.test(html)) {
      var origin = window.location.origin;
      var path = window.location.pathname;

      // Debug
      // console.log(origin + path);

      location.assign(origin + path);
    } else {
      // show alert ?

    }
  }

  function deletePostErr(xhr, status, err) {
    console.log( "Error: " + err);
    console.log( "Status: " + status);
  }

  $delete_link.click(function() {
    var $el = $(this);
    var post_id = $el.data('pid');
    var post_title = $el.data('ptitle');

    // console.log(post_id, post_title);

    if (window.confirm('Really delete post "' + post_title + '" ?')) {
      // send AJAX request
      // refresh main page when result comes back

      $.ajax({
        url : './process_post.php',
        data : {action : 'post_delete', post_id : post_id,
          post_title : post_title},
        type : 'POST',
        dataType: 'html',
        success : deletePostOk,
        error : deletePostErr
      });

    } else {
      // do nothing
      // log something ?
    }
  });



});