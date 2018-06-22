<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'accounts';
//switched to class because i felt like it was easier to work with than the array.
$mysqli = mysqli_connect($host,$user,$pass,$db);

if ($mysqli->connect_errno) 
{
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
