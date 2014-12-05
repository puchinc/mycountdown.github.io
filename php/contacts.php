<?php

/*
  |--------------------------------------------------------------------------
  | Mailer module
  |--------------------------------------------------------------------------
  |
  | These module are used when sending email from contact form
  |
 */


/* SECTION I - CONFIGURATION */

$receiver_mail = $_POST[ 'receiver_mail' ];
$mail_title = ($_POST[ 'website' ]) ? $_POST[ 'receiver_mail' ] : '[WebSite]';

/* SECTION II - CODE */

if ( ! empty( $_POST[ 'receiver_mail' ] ) && ! empty( $_POST[ 'name' ] ) && ! empty( $_POST [ 'email' ] ) && ! empty( $_POST [ 'message' ] ) ) {
	$subject = $_POST[ 'name' ];
	$email = $_POST[ 'email' ];
	$message = $_POST[ 'message' ];
	$subject = $mail_title;
	$header = "From: " . $_POST[ 'name' ] . "\r\nReply-To: " . $email . "";
	if ( mail( $receiver_mail, $subject, $message, $header ) )
		$result = '<div class="success">Your message was successfully sent.</div>';
	else
		$result = '<div class="fail">We are sorry but your message could not be sent.';
} else {
	$result = 'Please fill all the fields in the form.';
}
echo $result;
?>