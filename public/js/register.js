/**
 * Created by raynald on 1/12/15.
 */

$(document).ready(function() {

  var el = {
    $form : $('#register'),
    $status : $('#status'),
    $username : $('#username'),
    $pass1 : $('#password1'),
    $pass2 : $('#password2'),
    $email : $('#email'),
    $captcha : $('#captcha')
  };

  // handle ajax responses from server
  function successHandler(html) {
    /*
    console.log(html);

    el.$status.html(html);

    // None of these work, so....
    // validator.resetForm();
    // $fbForm.resetForm();
    // $fbForm[0].reset();

    // clear the form the brute force way
    // but only if contact form status is ok
    if (/(Thank you for registering)/.test(html)) {
      el.$username.val("");
      el.$pass1.val("");
      el.$pass2.val("");
      el.$email.val("");
      el.$captcha.val("");
    }
    */

    if (/(Thank you for registering)/.test(html)) {
      // Debug
      var href = window.location.href;
      //console.log(href);
      var arr = href.split('?');
      //console.log(arr[0]);

      location.assign(arr[0] + '?p=thank_you');
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
        required: true,
        maxlength: 20
      },
      password1: {
        required: true,
        maxlength: 40
      },

      password2: {
        required: true,
        equalTo:'#password1'
      },

      email: {
        required: true,
        email: true
      }
    },// end rules

    messages : {
      username: {
        required: "Please enter a user name.",
        maxlength: "User name cannot be greater than 20 characters"
      },
      password1: {
        required: "Please enter a password.",
        maxlength: "Password cannot be greater than 40 characters"
      },

      password2: {
        equalTo: 'Entered passwords do not match.'
      },

      email: {
        required: "Please enter your e-mail address.",
        email: "This is not a valid e-mail address."
      }

    }, // end messages

    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }, // end errorPlacement

    // send data to server
    submitHandler: function(form) {
      $.ajax( {
        url : './process_register.php',
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