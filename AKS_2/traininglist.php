<?php 
	include 'login-system/db.php';

	session_start(); //don't think this is necessary, but...i don't know enough about sessions yet
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" >
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>Training List</title>
    <style>
	.row {
	padding: 20px;
text-align: center;	
border: solid;
width: 100%; 
margin: auto;}

.card {
height: 250px;
border: solid;
border-color: green;
margin: auto;
padding: 15px;
align: center;
}

a{
text-decoration: none;
color: white;
text-align: center;
}
 a:hover {
color: white;
text-decoration: none;
background: black;
opacity: 0.5;
}

.complete {
	padding: 20px;
text-align: center;	
border: solid;
width: 100%; 
margin: auto;
color: green;
border-color: green;
}

.incomplete{
	padding: 20px;
text-align: center;	
border: solid;
width: 100%; 
margin: auto;
color: red;
border-color: red;
}
.progress{
	height: auto;
	margin:auto;
	width: 75%;
	padding: 5px;
	background: black;
}
.progress-bar.progress-bar-success {
	background-color: green;
}
.dropup {
	margin:auto;
	width: 100%;
}

.btn.btn-primary.dropdown-toggle{
	width: 100%;
	background-color: green;
}
.dropdown-menu{
	width: 100%;
	background-color: black;
	color: white;
	position: relative;
}
.col-sm-12{
	border-color: white;
		width: 100%;
padding: 30px;
}
.dropdown-menu.show {
    position: absolute;
    will-change: transform;
    top: 0px;
    left: 0px;
    transform: translate3d(0px, 30px, 0px);
	margin: auto;
}
.divider{

	background-color: green;
    padding-top: 2px;
	padding-bottom: 2px;
}
.container{
	width: 100%;
	margin: auto;
}

</style>
</head>
<body>
    <?php

	
	$column_count = '15';//mysqli_num_rows("DESCRIBE test_results");	
	$complete_count = '13';//mysqli_fetch_assoc(mysqli_query("SELECT * FROM test_results WHERE user_id=$id['id']"));
	//this is the line that was giving me the most trouble. it's not setup to get results from all columns at the same time with one query
	
	//progress bar
	$complete_percent = ($complete_count / $column_count)*100; 
	echo "<br><div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='"
	.$column_count."aria-valuemin='0' aria-valuemax='100' style='width:".$complete_percent."%'>"
	.number_format($complete_percent)." %<br> ".$complete_count . " out of " . $column_count . 
	" complete<br><br></div></div><br><br>";
	
	
	
	//dropdown menu
		echo "	<div class='container'><div class='dropup'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Training List    </button>  <ul class='dropdown-menu'>";
	$testvalue = 'incomplete' ; 
		//populate the dropdown menu with MySql results - does not work yet
	for ($i = "A"; $i < "P" ; $i++){
		//if statement selecting if column value = 1, $testvalue = 'complete'
		//else $testvalue = 'incomplete'
	
    echo "<li><div class='col-sm-12'><a href='Part ".$i."/index.html'>Test ".$i."<div class ='incomplete' id='test_".$i."'>Not Passed</div></a></div></li><li class='divider'></li>"; //replace 'incomplete' with ".$testvalue."
	}
	echo "</ul></div></div>";

	?>
</body>
</html>