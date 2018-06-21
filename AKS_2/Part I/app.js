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

    
	new Question("YOU ARE MAKING YOUR ROUNDS AT A SHOPPING CENTER AND COME TO A PICKUP TRUCK PARKED AT THE CURB. IN THE BACK OF THE TRUCK ARE TWO COLOR TV SETS STILL IN THEIR PACKING BOXES. THE TWO MEN IN THE TRUCK LOOK SUSPICIOUS. ACCORDING TO THE LAW YOU CAN ARREST THESE TWO MEN. ", 
	["True", "False","", ""], 
	"False"),
	new Question("YOU ARE ON DUTY AS A SECURITY GUARD/PROPRIETARY PRIVATE SECURITY OFFICER AT A FACTORY AND YOU OBSERVE A SUSPECT POURING WHAT APPEARS TO BE GASOLINE ON THE GROUND NEXT TO SOME STORAGE TANKS. AS YOU APPROACH, HE LIGHTS A MATCH AND THROWS IT ON THE LIQUID, IGNITING IT. ACCORDING TO THE LAW YOU CAN ARREST THIS MAN.", 
	["True", "False","", ""], 
	"True"),
	new Question("ACCORDING TO THE LAW, WHICH OF THE FOLLOWING CONDITIONS MUST EXIST BEFORE YOU CAN MAKE A MISDEMEANOR ARREST?", 
	["The suspect must admit to the crime.", "The crime must have been committed or attempted in your presence.","Someone told you the suspect did it.", ""], 
	"The crime must have been committed or attempted in your presence."),
	new Question("ACCORDING TO THE LAW, WHICH OF THE FOLLOWING CONDITIONS MUST EXIST BEFORE YOU CAN MAKE A FELONY ARREST?", 
	["The felony must have been committed and you have reason to believe the person you are arresting actually committed it.", "You think a crime has been committed and the person you are arresting is the only person around.","A citizen tells you he thinks someone was just assaulted.", ""], 
	"The felony must have been committed and you have reason to believe the person you are arresting actually committed it.")
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





