<?php
	require 'db.php';
	include 'profile.php'; // for the session
	
	$email = $_SESSION['email'];
	$_SESSION['results'] = $_POST['results'];
	$_SESSION['test'] = $_POST['test'];
	
	$results = mysqli_real_escape_string($mysqli, $_POST['results']);
	$test = mysqli_real_escape_string($mysqli, $_POST['test']);
	$grab = mysqli_query($mysqli, "SELECT * FROM users WHERE email = '$email';");
	$id = mysqli_fetch_array($grab);

	//right now, $test_result is not working. But I need mysql to recognize the damn test that is being changed.
	$query = mysqli_query($mysqli, "UPDATE test_results SET B_result = '$results' WHERE user_id='$id[id]';");
	
	
?>