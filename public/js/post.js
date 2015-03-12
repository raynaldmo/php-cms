/**
 * Created by raynald on 3/3/15.
 */

$(document).ready(function() {

  //--------------- Handle form submission -----------------/
  // Add event handler for cancel button
  // redirect to main page
  $('#cancel').click(function() {
    var href = window.location.href;
    var arr = href.split('?');

    location.assign(arr[0] + '?p=main');
  });

  var el = {
    $form : $('#post_add'),
    $status : $('#status'),
    $post_title : $('#post_title'),
    $post_text : $('#post_text')
  };

  // handle ajax responses from server
  function successHandler(html) {
    // Debug
    // console.log(html);

    el.$status.html('');

    if (/(Post saved)/.test(html)) {
      el.$status.html(html);

      // Debug
      var href = window.location.href;
      console.log(href);
      var arr = href.split('?');
      console.log(arr[0]);

      // location.assign(arr[0] + '?p=main&action=login');
    } else {
      el.$status.html(html);

    }
  }

  function errorHandler(xhr, status, err) {
    console.log( "Error: " + err);
    console.log( "Status: " + status);
  }

  // Configure validation plugin
  var validator = el.$form.validate({
    rules: {
      post_title: {
        required : true,
        maxlength: 50
      },

      post_text: {
        required: true
      }
    },// end rules

    messages : {
      post_title: {
        required: "Please enter a title for the post",
        maxlength: "Post title cannot be greater than 50 characters"
      },

      post_text: {
        required: "Please enter your post"
      }

    }, // end messages

    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }, // end errorPlacement

    // send data to server
    submitHandler: function(form) {
      $.ajax( {
        url : './process_post.php',
        data : $(form).serialize(),
        type : 'POST',
        dataType: 'html',
        success : successHandler,
        error : errorHandler

      });

      return false;
    }

  }); // end validate()

  //--------------- Handle post edit link from main.php  -----------------/
  function editPostOk(post) {
    // Debug
    // console.log('editPostOk');

    // post comes to us already 'JSON-parsed' thanks to jQuery.
    // No need to call JSON.parse();
    console.log(post);

    // post.data.forEach(function(data) {
    //  console.log(data);
    // });

    // see process_post.php for data array format :
    // data[0] -> post_id, data[1] -> user_id, data[2] -> post_title,
    // data[3] -> post_text, data[4] -> post_date, data[5] -> post_ts

    // populate form
    $('#post_id').val(post.data[0]);
    $('#post_title').val(post.data[2]);
    $('#post_text').val(post.data[3]);

  }

  function editPostErr(xhr, status, err) {
    console.log( "Error: " + err);
    console.log( "Status: " + status);
  }

  // Decode query string
  // If we got re-directed from main.php to post.php in order to
  // edit a post, location will look something like this:
  // http://192.168.0.252/php-cms/public/index.php?p=post&action=edit&pid=47
  var qd = {};

  console.dir(location.search); // ?p=post&action=edit&pid=47

  var arr = location.search.substr(1).split('&');
  arr.forEach(function(val) {
    var a = val.split('=');
    // build key,value pairs of name , value
    // p : post, action : edit, pid : 47
    qd[a[0]] = a[1];
  });

  // console.dir(qd);

  // check that all necessary properties are present
  if (('p' in qd) && ('action' in qd) && ('pid' in qd)) {
    // shoot off AJAX request
    $.ajax({
      url : './process_post.php',
      data : {action : 'post_edit', post_id : qd['pid']},
      type : 'POST',
      dataType: 'json',
      success : editPostOk,
      error : editPostErr
    });
  }

}); // end ready