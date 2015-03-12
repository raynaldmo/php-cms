/**
 * Created by raynald on 2/27/15.
 */

$(document).ready(function() {

  var el = {
    $form : $('#login'),
    $status : $('#status'),
    $username : $('#username'),
    $pass : $('#password'),
    $email : $('#email')
  };

  // handle ajax responses from server
  function successHandler(html) {

    if (/(Login success)/.test(html)) {
      // Debug
      var href = window.location.href;
      console.log(href);
      var arr = href.split('?');
      console.log(arr[0]);

      location.assign(arr[0] + '?p=main&action=login');
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
      username: {
        maxlength: 20
      },
      password: {
        required: true,
        maxlength: 40
      },

      email: {
        email: true
      }
    },// end rules

    messages : {
      username: {
        maxlength: "User name cannot be greater than 20 characters"
      },
      password: {
        required: "Please enter a password.",
        maxlength: "Password cannot be greater than 40 characters"
      },

      email: {
        email: "This is not a valid e-mail address."
      }

    }, // end messages

    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }, // end errorPlacement

    // send data to server
    submitHandler: function(form) {
      $.ajax( {
        url : './process_login.php',
        data : $(form).serialize(),
        type : 'POST',
        dataType: 'html',
        success : successHandler,
        error : errorHandler

      });

      return false;
    }

  }); // end validate()

}); // end ready