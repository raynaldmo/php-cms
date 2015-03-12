/**
 * Created by raynald on 1/12/15.
 */

$(document).ready(function() {

  var el = {
    $form :         $('#contact'),
    $status :       $('#status'),
    $name :         $('#name'),
    $email :        $('#email'),
    $email_again :  $('#email-again'),
    $comments :     $('#comments')
  };

  // handle ajax responses from server
  function successHandler(html) {
    console.log(html);

    el.$status.html(html);

    // None of these seem to work
    // validator.resetForm();
    // $form.resetForm();
    // $form[0].reset();

    // ...so clear the form the brute force way
    // but only if contact form status is ok
    if (/(Thanks)/.test(html)) {
      el.$name.val("");
      el.$email.val("");
      el.$email_again.val("");
      el.$comments.val("");
    }

  }

  function errorHandler(xhr, status, err) {
    console.log( "Error: " + err);
    console.log( "Status: " + status);
  }

  // Configure validation plugin
  var validator = el.$form.validate({
    rules: {
      name: {
        required: true,
        maxlength: 80
      },
      email: {
        required: true,
        email: true
      },
      email_again: {
        equalTo:'#email'
      },
      comments: {
        required: true,
        maxlength: 250
      }
    },// end rules

    messages : {
      name: {
        required: "Please enter your name.",
        maxlength: "Name must be less then 80 characters"
      },
      email: {
        required: "Please enter your email address.",
        email: "This is not a valid email address."
      },
      email_again: {
        equalTo: 'The two email addresses do not match.'
      },

      comments: {
        required: "Please enter comments or questions here.",
        maxlength: "Maximum of 250 characters allowed."
      }
    }, // end messages

    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }, // end errorPlacement

    // send data to server
    submitHandler: function(form) {
      $.ajax( {
        url : './process_contact.php',
        data : $('#contact').serialize(),
        type : 'POST',
        dataType: 'html',
        success : successHandler,
        error : errorHandler

      });

      return false;
    }

  }); // end validate()

}); // end ready