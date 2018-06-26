<?php
// Send registration confirmation link (verify.php)
session_start();
require "db.php";

function sendMail()
{
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['first_name'] = $_POST['firstname'];
    $_SESSION['last_name'] = $_POST['lastname'];
    $_SESSION['result'] = 0 ;
    $_SESSION['hash'] = $_POST['hash'];

    $first_name = $_SESSION['first_name'];
	$last_name = $_SESSION['last_name'];
	$email = $_SESSION['email'];
	$active = $_SESSION['active'];
    $_SESSION['message'] = ""; 
    $hash = $_SESSION['hash'];

	$to      = $email;
	$subject = 'Account Verification (geoffsher.com )';
	$headers = 'From: geoff@geoffsher.com' . "\r\n";
	$message_body = '
	Hello '.$first_name.',

	Thank you for signing up!
	Please click this link to activate your account:

	http://geoffsher.com/login-system/verify.php?email='.$email.'&hash='.$hash;  
    
    mail( $to, $subject, $message_body, $headers );

    header("location: profile.php"); 
}
?>