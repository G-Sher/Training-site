<?php
/* Displays user information and some useful messages */
session_start();
require 'db.php';
include 'mail.php';
// Check if user is logged in using the session variable
//if($_SESSION['result'] = 0){
//	newUserState();
//}
//else
//{
//	testedState();
//}
//function newUserState(){
//generate code to check the DB for user payment status - implement on attempt to access quiz?
	if ( $_SESSION['logged_in'] != 1 ) {
	  $_SESSION['message'] = "You must log in before viewing your profile page!";
	  header("location: error.php");    
	}
	/*elseif ($_SESSION['paid'] != 'paid'){
		$_SESSION['message'] = "You must pay before taking the tests.";
		header("location: error.php");    
	}*/
	else {
		// Makes it easier to read
		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$email = $_SESSION['email'];
		$active = $_SESSION['active'];
		$_SESSION['message'] = ""; 

	$column_count = 14 ;	//15 letters for A to O
	$complete_count = 1 ; //needs to be updated from a MySQL query
	/*
	if(mysqli_query($mysqli, "SELECT * FROM test_results WHERE email = ".$_SESSION['email']." AND ".$i."_result = '1'") > 0){
		$complete_count += 1; //how do we pull the $_session info into this page?
		$testvalue= 'complete';
	}
	else {
		$complete_count; 
		$test_value='incomplete';
	}
	once this part is completed, we can merge this chunk of code with lines 99-103
	*/
		
	echo "<html>";
	echo "<head>";
	  echo "<meta charset='UTF-8'>";
	  echo "<title>Welcome $first_name" . " $last_name </title>"; //fixed, was saying "Welcome = firstname' 'lastname
	   include 'css/css.html'; 
	   include 'js/bootstrap.html';
	   echo "<link rel='stylesheet' href='css/training.css' >"; 
	   echo "<link rel='stylesheet' href='css/style.css'>";
	echo "</head>";

	echo "<body>";
	  echo "<div class='form'>";

			  echo "<h1>Welcome</h1><p>";
			   
			  // Display message about account verification link only once
			  if ( isset($_SESSION['message']) )
			  {
				  echo $_SESSION['message'];
				  
				  // Don't annoy the user with more messages upon page refresh
				  unset( $_SESSION['message'] );
			  }
			  echo "</p>";
			  // Keep reminding the user this account is not active, until they activate
			  if (!$active){
				  echo
				  '<div class="info">
				  Account is unverified, please confirm your email by clicking
				  on the email link!
				  </div>
				  <div>
					  <a href= "sendMail();">Resend E-mail</a>
					</div>';
			  }

			  echo "<h2>" .$first_name. " " .$last_name. "</h2>";
			  echo "<p>". $email ."</p>";
		
	//progress bar
	$complete_percent = ($complete_count / $column_count)*100; 
	
	echo "<br>Progress toward final exam<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='"
	.$column_count."aria-valuemin='0' aria-valuemax='100' style='width:".$complete_percent."%'>"
	.number_format($complete_percent)." %<br> ".$complete_count . " out of " . $column_count . 
	" complete<br><br></div></div>";
	//end of progress bar
	
	$letterarray = range("A","O");// an array that will iterate the loop to generate the dropdown quizzes
	
	//dropdown
	if ($complete_count < $column_count) {
		echo "	<div class='dropup'><button class='button button-block' type='button' data-toggle='dropdown'>Training List    </button>  <ul class='dropdown-menu'><li class='divider'></li>";
	$testvalue = 'complete' ; //leave here to reset the $testvalue variable before checking the DB. ensures it will not get accidentally approved
//populate the dropdown menu with MySql results - does not work yet

for ($i = $letterarray[0]; $i < $letterarray[$complete_count+1] ; $i++){
		if ($i == $letterarray[$complete_count]){
			$testvalue = 'incomplete';
		}
		else {
			$testvalue = 'complete';
		}
		
    echo "<li><div class='col-sm-12'><a href='../Part ".$i."/index.html'>Quiz ".$i."<div class ='".$testvalue."' id='test_".$i."'>Go To Quiz</div></a></div></li><li class='divider'></li>"; //replace 'incomplete' with ".$testvalue."
	}
	echo "</ul></div>";
}





 if ($complete_count >= $column_count){	
		echo "<a href='http://www.bsis.ca.gov/industries/g_train.shtml' target = '_blank'><button class='button button-block' name='review'/>Exam Review</button></a>";	 
		echo "<a href='#finalexam'><button class='button button-block' name='test'/>FINAL EXAM</button></a>";
	
}// only show the test button for final exam if all other quizzes have been passed.
			  echo "<br><br><br><br><a href='logout.php'><button class='button button-block' name='logout'/>Log Out</button></a>";

		echo "</div>";
		
	echo "<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.s'></script>";
	echo "<script src='js/index.js'></script></body></html>";
	}
?>
