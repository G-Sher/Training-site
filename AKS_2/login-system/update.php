<?php
	require 'db.php';
	include 'profile.php'; // for the session
	
	$first_name = $_SESSION['first_name'];
	$last_name = $_SESSION['last_name'];
	$email = $_SESSION['email'];
	$active = $_SESSION['active'];
	$_SESSION['results'] = $_POST['results'];
	$_SESSION['test'] = $_POST['test'];
	
	$results = mysqli_real_escape_string($mysqli, $_POST['results']);
	$test = mysqli_real_escape_string($mysqli, $_POST['test']);
	
	$grab = mysqli_query($mysqli, "SELECT * FROM users WHERE email = '$email';");
	$id = mysqli_fetch_array($grab);
	
	//this can be worked on to make it work dynamically with each test. Otherwise we'll
	//need to include a copy of this file for every test folder
	$query = mysqli_query($mysqli, "UPDATE test_results SET '$test'= '$results' WHERE user_id='$id[id]';");
	
	
?>