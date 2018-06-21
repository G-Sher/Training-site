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
color: black;
}
 a:hover {
color: black;
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


</style>
</head>
<body>
    <?php 
	session_start();
	require '/login_system/db.php';
	
	$column_count = mysql_num_rows(mysql_query("describe test_results"));	
	$complete_count = mysql(mysql_query("SELECT * FROM test_results WHERE user_id=$id[id] AND "));
	echo $complete_count . " out of " . $column_count . " complete<br><br>"; //stats for progress bar

	echo "<h1>Training List</h1>";
    echo "<div class='row'>";
    echo "<div class='col-sm-2'><a href='Part'". $lettercode."/index.html'><div class='card'>";
	echo "<div class='row'>Test ".$lettercode."</div><div class ='row' >Title</div>";
	echo "<div class ='".$testvalue."' id='test_".$lettercode.">Not Passed</div></div></a>";
	echo "</div>";
		

	?>
</body>
</html>