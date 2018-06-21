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

    new Question("A SECURITY GUARD/PROPRIETARY PRIVATE SECURITY OFFICER’S LAWFUL AUTHORITY IS THE SAME AS THAT OF A PEACE OFFICER. ", 
	["Yes", "No","", ""], //LEAVE BLANK "" FOR EMPTY CHOICES
	"No"),
    new Question("DURING AN EMERGENCY ON THE EMPLOYER’S PROPERTY, A PEACE OFFICER INSTRUCTS A SECURITY GUARD/PROPRIETARY PRIVATE SECURITY OFFICER TO STAND OUT OF THE WAY BEHIND A POLICE LINE, THE SECURITY GUARD/PROPRIETARY PRIVATE SECURITY OFFICER MUST:", 
	["Refuse, as the security guard/proprietary private security officer's duties are different from those of the peace officer.", "Cooperate and follow the lawful orders of the peace officer.","Apprehend the persons violating the law on the employer’s or client’s property since the security guard/proprietary private security officer’s duty is to protect the property and person of the employer or client.", ""], 
	"Cooperate and follow the lawful orders of the peace officer.")
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





