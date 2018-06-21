<?php

require 'profile.php';
require 'db.php';
session_start();
$id = mysqli_query($mysqli,"SELECT id FROM users WHERE email='$email' AND hash='$hash' AND active='0'");



$query = mysql_query($mysqli, "UPDATE test_results SET A_result = 1 WHERE test_results.user_id = '12'");


?>