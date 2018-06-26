<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */
require 'db.php';
include 'mail.php';

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['result'] = 0 ;

// Escape all $_POST variables to protect against SQL injections.
$first_name = mysqli_real_escape_string($mysqli,$_POST['firstname']);
$last_name = mysqli_real_escape_string($mysqli,$_POST['lastname']);
$email = mysqli_real_escape_string($mysqli,$_POST['email']);
$password = mysqli_real_escape_string($mysqli, password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = mysqli_real_escape_string($mysqli, md5( rand(0,1000) ) );
      
// Check if user with that email already exists
$result = mysqli_query($mysqli,"SELECT * FROM users WHERE email='$email'");

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = mysqli_query($mysqli,"INSERT INTO users (first_name, last_name, email, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')");
	
	//initiate the 'test_results' table with matching user_ID number and 0s for all test results.
	$query = mysqli_query($mysqli, "SELECT * FROM users WHERE hash = '$hash'");
	$id = mysqli_fetch_array($query);
	$result = mysqli_query($mysqli, "INSERT INTO test_results (user_id) VALUES ('$id[id]')");
	
    // Add user to the database
    if ($sql){

			$_SESSION['active'] = 0; //0 until user activates their account with verify.php
			$_SESSION['logged_in'] = true; // So we know the user has logged in
			$_SESSION['message'] =
					"Confirmation link has been sent to $email, please verify
					 your account by clicking on the link in the message!";
					 
			$to      = $email;
			$subject = 'Account Verification (geoffsher.com )';
			$headers = 'From: geoff@geoffsher.com' . "\r\n";
			$message_body = '
				Hello '.$first_name.',
					
				Thank you for signing up!
				Please click this link to activate your account:
					
				http://geoffsher.com/login-system/verify.php?email='.$email.'&hash='.$hash;  
					 
			mail($to, $subject, $message_body, $headers );
				 
			header("location: profile.php"); 
			
	//	}
    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}