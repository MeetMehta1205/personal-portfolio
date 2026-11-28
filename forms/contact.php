<?php
/**
 * Standalone contact form handler for Hostinger (no paid library needed).
 * Replies with exactly "OK" on success, which is what assets/vendor/php-email-form/validate.js expects.
 *
 * SETUP: change $site_email to a real mailbox on YOUR domain
 * (create it in hPanel -> Emails -> Email Accounts, e.g. no-reply@yourdomain.com).
 * Hostinger often blocks/spam-folders mail sent "from" a domain that isn't yours.
 */

// Where the messages are delivered
$receiving_email_address = 'meetmehta664@gmail.com';

// Sender address: MUST be an email on your Hostinger domain
$site_email = 'support@meetmehta.dev';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die('Method not allowed.');
}

// Collect + clean input
$name    = trim(strip_tags($_POST['name']    ?? ''));
$email   = trim($_POST['email']              ?? '');
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

// Validate
if ($name === '' || $subject === '' || $message === '') {
  die('Please fill in all the fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die('Please enter a valid email address.');
}

// Block header injection
foreach ([$name, $email, $subject] as $field) {
  if (preg_match('/[\r\n]/', $field)) {
    die('Invalid input.');
  }
}

// Build the email
$mail_subject = $subject;
$body  = "Name: $name\n";
$body .= "Email: $email\n\n";
$body .= "Message:\n$message\n";

$headers  = "From: Meet Mehta <$site_email>\r\n";
$headers .= "Reply-To: $name <$email>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send (the 5th arg sets the envelope sender, helps deliverability on Hostinger)
if (mail($receiving_email_address, $mail_subject, $body, $headers, "-f$site_email")) {
  echo 'OK';
} else {
  http_response_code(500);
  echo 'Sorry, the message could not be sent. Please try again later.';
}