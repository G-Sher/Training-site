function populate() {
    if(quiz.isEnded()) {
        showScores();
    }
    else {
        // show question
        var element = document.getElementById("question");
        element.innerHTML = quiz.getQuestionIndex().text;

        // show options
        var choices = quiz.getQuestionIndex().choices;
		var x;
        for(var i = 0; i < choices.length; i++) {

			var element = document.getElementById("choice" + i);
			x = document.getElementById("btn"+i);
			element.innerHTML = choices[i];
			
			if (choices[i] == ""){
			x.style.visibility = "hidden";
			}
			else{	
			x.style.visibility = "visible";
			
			guess("btn" + i, choices[i]);
			}
			
        }

        showProgress();
    }
};

function guess(id, guess) {
    var button = document.getElementById(id);
    button.onclick = function() {
        quiz.guess(guess);
        populate();
    }
};



function showProgress() {
    var currentQuestionNumber = quiz.questionIndex + 1;
    var element = document.getElementById("progress");
    element.innerHTML = "Question " + currentQuestionNumber + " of " + quiz.questions.length;
};


function showScores() {
    var gameOverHTML = "<h1>Result</h1>";
    gameOverHTML += "<h2 id='score'> You scored: " + quiz.score + "</h2>";
	if (quiz.score < quiz.questions.length){
		gameOverHTML += "<h2> You did not score high enough to pass this section.";
	}
	else{
gameOverHTML += "<div align= 'center'><h2> Congratulations! You have completed this section!</h2></br>";
		//realized you need a back button regardless of pass/fail. This will eventually be used to also update the database with pass/fail, probably
		//gameOverHTML += "<button onclick= '../ajaxStuff.js' id='back' style='font-size: 25px';>My Profile</button></div>";
		gameOverHTML += "<button style= 'font-size: 25px';><a href= '../login-system/profile.php' onclick= 'ajaxStuff();'>Go here</a></button>";
	
		// I wonder if we can get it to run the JQuery without hitting that ^ button.
	
	}
    var element = document.getElementById("quiz");
    element.innerHTML = gameOverHTML;
};

// create questions
var questions = [

    new Question("YOUR EMPLOYER ASKS YOU TO INSPECT THE PERSONAL BELONGINGS OF EMPLOYEES LEAVING THE PLANT. HE HAS ANNOUNCED THIS POLICY TO ALL EMPLOYEES. WHAT IS IMPORTANT TO REMEMBER ABOUT INSPECTIONS? ", ["Never inspect without cooperation from the employee.", "Never touch the employee.","Never touch the employee’s belongings.", "All the rules above."], "All the rules above."),
	new Question("AN EMPLOYEE WHO IS LEAVING WORK WALKS UP TO YOU AND HANDS YOU HIS LUNCH PAIL FOR INSPECTION. WHAT SHOULD YOU DO?", ["Accept it and open it to look inside.", "Decline to take it and instead ask the employee to open it so you can inspect the contents.","Take it but have the employee open it.", ""], "Decline to take it and instead ask the employee to open it so you can inspect the contents."),
	new Question("YOU ARE WALKING THROUGH THE PARKING LOT AND OBSERVE COMPANY EQUIPMENT IN THE BACK SEAT OF A CAR THROUGH A CLOSED BUT UNOBSTRUCTED WINDOW OF THE VEHICLE. YOU MAY:", ["Look closely through the window (without entering the vehicle) at the equipment, and make notes which identify the equipment, the make and model of the vehicle and its license number as well as the vehicle’s location in the parking lot, and render this report to your employer or client.", "Enter the vehicle to determine if the equipment is stolen and if so take it to your employer or client.","", ""], "Look closely through the window (without entering the vehicle) at the equipment, and make notes which identify the equipment, the make and model of the vehicle and its license number as well as the vehicle’s location in the parking lot, and render this report to your employer or client.")
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





