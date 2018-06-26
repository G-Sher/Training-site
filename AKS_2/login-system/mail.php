<?php
// Send registration confirmation link (verify.php)
require "db.php";

function sendMail()
{
	$to      = $email;
	$subject = 'Account Verification (geoffsher.com )';
	$headers = 'From: geoff@geoffsher.com' . "\r\n";
	$message_body = '
	Hello '.$first_name.',

	Thank you for signing up!
	Please click this link to activate your account:

	http://geoffsher.com/login-system/verify.php?email='.$email.'&hash='.$hash;  
    mail( $to, $subject, $message_body, $headers );
}
?>