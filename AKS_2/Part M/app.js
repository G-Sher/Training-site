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
		gameOverHTML += "<div align= 'center'><h2> You did not score high enough to pass this section</h2></br>";
		//back button here. Still needs to be changed because of timer.
		gameOverHTML += "<button id='back' style='font-size: 25px';><a href='index.html' style='color: white';>Try Again!</a></button></div>";
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

    new Question("HOW SOON MUST YOU TURN A SUSPECT OVER TO THE PEACE OFFICER AFTER AN ARREST? ", 
	["Without delay.", "At any time.","After reporting to your supervisor. ", ""], 
	"Without delay."),
    new Question(" IT WOULD BE LAWFUL IF YOU HELD A SUSPECT FOR TWO HOURS SO YOUR SUPERVISOR COULD QUESTION HIM/HER BEFORE YOU CALLED THE POLICE. 	", 
	["True ", "False","", ""], 
	"False"),
    new Question("IF YOU HAVE MADE A LAWFUL ARREST, THE LOCAL PEACE OFFICER: ", 
	["Must take custody of the suspect only if the crime is a felony.", "Must take custody of the suspect only if the crime is a misdemeanor.","Must take custody of the suspect regardless of whether the crime is a misdemeanor or a felony.", "Can refuse to take custody of the suspect."],
	"Can refuse to take custody of the suspect."),
    new Question("IF THE CRIME COMMITTED IS A FELONY, WHO WILL MAKE THE ARREST?", 
	["A proprietary private security guard/proprietary private security officer.", "The police.","Either A or B.", ""], 
	"Either A or B."),
	new Question("WHAT WILL PROBABLY BE REQUIRED OF YOU AFTER MAKING AN ARREST? ", 
	["Meeting with the district attorney.", "Attending the suspect’s hearing.","Testifying at the suspect’s trial.", "All of the above."], 
	"All of the above.")
	];
	

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





