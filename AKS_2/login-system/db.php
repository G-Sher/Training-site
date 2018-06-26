<?php
/* Database connection settings */
$host = 'localhost';
$user = 'thesnugg_user';
$pass = 'phitins26';
$db = 'thesnugg_accounts';
//switched to class because i felt like it was easier to work with than the array.
$mysqli = mysqli_connect($host,$user,$pass,$db);

if ($mysqli->connect_errno) 
{
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
