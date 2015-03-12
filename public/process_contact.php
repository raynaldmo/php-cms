<?php
/**
 * Created by PhpStorm.
 * User: raynald
 * Date: 3/12/15
 * Time: 12:12 PM
 */

// Process contact form. We get to here via ajax request

//########################################################################
// NOTE!! : All echo/print output in this file will be sent
// as AJAX response (see contact.js)
//#########################################################################

if (isset($_POST['submitted']) ) {

  $name         = strip_tags($_POST['name']);
  $email        = strip_tags($_POST['email']);
  $email_again  = strip_tags($_POST['email-again']);
  $comments     = strip_tags($_POST['comments']);

  // check inputs
  if (empty($name) or empty($email) or
    empty($email_again) or empty($comments)) {
    exit("<p class='contact-form-err'>Please fill in all required fields</p>");
  }

  if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("<span class='contact-form-err'>You entered an invalid email address.
      Please enter a valid email address</span>");
  }

  if ($email !== $email_again) {
    die("<span class='contact-form-err'>Entered email addresses don't match.
      Please try again</span>");
  }

/*
  // set up mail parameters
  $toaddress = "raynaldmo@gmail.com";
  $subject = "Feedback from myHistoryNotes Website";

  $mailcontent = "Customer name: " . $name . "\n" .
    "Customer email: " . $email . "\n" .
    "Customer comments:\n" . $comments . "\n";

  $fromaddress = "From: " . $email;

  // invoke mail() function to send mail
  mail($toaddress, $subject, $mailcontent, $fromaddress);

*/

  echo '<p class="contact-form-ok">Thanks for contacting us and visiting our site.
    We appreciate the feedback.<br> For questions, we\'ll respond back as soon
    as we can.</p>';

}