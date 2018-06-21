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

    new Question("IN ORDER TO MAINTAIN A GOOD WORKING RELATIONSHIP WITH THE LOCAL LAW ENFORCEMENT, YOU SHOULD:", ["Never play “cop.”", " Cooperate with local law enforcement.","Both A and B.", ""], "Both A and B."),
	new Question("SELECT WHETHER THE STATEMENT IS A FACT OR CONCLUSION<br><br>Statement: He intended to kill her.", ["Fact", "Conclusion","", ""], "Conclusion"),
	new Question("SELECT WHETHER THE STATEMENT IS A FACT OR CONCLUSION<br><br>Statement: She was trying to steal the ring from the jewelry counter.", ["Fact", "Conclusion","", ""], "Conclusion"),
	new Question("SELECT WHETHER THE STATEMENT IS A FACT OR CONCLUSION<br><br>Statement: He ran to the fence.", ["Fact", "Conclusion","", ""], "Fact"),
	new Question("SELECT WHETHER THE STATEMENT IS A FACT OR CONCLUSION<br><br>Statement: He opened the window and entered.", ["Fact", "Conclusion","", ""], "Fact"),
	new Question("WHAT MAIN POINTS SHOULD BE INCLUDED IN A REPORT?", ["Address, location, scenery, and other pertinent details.", "Who, what, where, when, how, and names of witnesses.","Who, what, where, when, why, and how", ""], "Who, what, where, when, how, and names of witnesses.")
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





