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

    new Question("TWO MEN GRAB AN EMPLOYEE GETTING OUT OF HIS/HER CAR IN THE PARKING LOT. THEY SHOVE THE EMPLOYEE INTO THEIR CAR AND START DRIVING AWAY. THIS MAY BE:", 
	["Kidnapping, a felony.", "Robbery, a felony.","", ""], 
	"Kidnapping, a felony."),
	new Question("A FAMILY RETURNS HOME TO DISCOVER THEIR HOUSEHOLD FURNISHINGS ARE MISSING. THEY MAY BE VICTIMS OF:", 
	["Burglary, a felony.", "Robbery, a felony.","", ""], 
	"Burglary, a felony."),
	new Question("AN EX-EMPLOYEE OF A SUPERMARKET WAITS IN HER CAR UNTIL THE MANAGER CLOSES THE BUILDING AND WALKS TOWARDS HIS CAR. SHE STEPS OUT OF HER CAR, POINTS A GUN AT THE MANAGER, AND FIRES THREE SHOTS, KILLING THE MANAGER. WHAT CRIME MAY HAVE BEEN COMMITTED?", 
	["Arson, a felony.", "Murder, a felony.","", ""], 
	"Murder, a felony."),
	new Question("TOM IS ANGERED BECAUSE JIM WAS DANCING WITH TOM’S GIRLFRIEND. TOM WAITS OUTSIDE THE DOOR WITH A LARGE BOARD HE PICKED UP FROM A CONSTRUCTION SITE. WHEN JIM COMES OUT OF THE BUILDING, TOM SWINGS THE BOARD AND HITS JIM IN THE FACE. THIS IS:", 
	["Assault with a deadly weapon, a felony.", "Battery, a misdemeanor.","", ""], 
	"Assault with a deadly weapon, a felony."),
	new Question("SECRETARIES LINDA AND JUDY GET INTO AN ARGUMENT OVER PAY RAISES. SECRETARY JUDY LEAVES THE ARGUMENT TO GO TO THE RESTROOM. SECRETARY LINDA, STILL ANGRY, HIDES BEHIND A LARGE BOOKCASE. AS JUDY RETURNS, LINDA TRIES TO TOPPLE THE BOOKCASE ONTO JUDY. THE BOOKCASE BARELY MISSES HER. THIS IS:", 
	["Assault, a misdemeanor", "Assault with a deadly weapon, a felony.","Either A or B", ""], 
	"Assault, a misdemeanor"),
	new Question("A MAN WHO HAS PURCHASED A NEW $975.00 LAWN MOWER PUSHES IT OUT TO HIS CAR AND LEAVES IT BESIDE THE TRUNK WHILE HE GOES BACK INTO THE STORE TO GET A SACK OF FERTILIZER. WHILE HE IS GONE, SOMEONE DRIVES UP IN A STATION WAGON, PUTS THE NEW LAWN MOWER IN THE BACK OF THE WAGON, AND DRIVES OFF. WHAT CRIME IS THIS?", 
	["Robbery, a felony.", "Grand theft, a felony.","", ""], 
	"Grand theft, a felony."),
	new Question("A MAN IS SITTING IN THE LOBBY OF AN AUTOMOBILE SHOWROOM. AT 5:00 P.M. THE SECURITY OFFICER STARTS TO LOCK UP FOR THE NIGHT AND ASKS THE MAN TO LEAVE. THE MAN REFUSES, SO THE SECURITY OFFICER ASKS IF THE MAN IS WAITING FOR SOMEONE. THE MAN REPLIES, “NONE OF YOUR BUSINESS.” AGAIN, THE SECURITY OFFICER ASKS THE MAN TO LEAVE. HE REFUSES. THE MAN HAS COMMITTED THE CRIME OF:", 
	["Trespassing, a misdemeanor.", "Disturbing the peace, a misdemeanor.","", ""], 
	"Trespassing, a misdemeanor."),
	new Question("AN ANGRY EMPLOYEE POURS LIGHTER FLUID IN A TRASH CONTAINER IN THE STOCKROOM, THEN LIGHTS IT WITH A MATCH. THIS IS:", 
	["Vandalism, a misdemeanor.", "Arson, a felony.","", ""], 
	"Arson, a felony."),
	new Question("YOU DRIVE UP TO A STORE AT 2:00 A.M. AND OBSERVE TWO MEN BREAKING OPEN A DOOR AND BEGINNING TO LOAD A PICKUP TRUCK WITH MERCHANDISE. WHEN THEY SEE YOU, THEY TURN AND RUN. THIS IS:", 
	["Burglary, a felony.", "Robbery, a felony.","", ""], 
	"Burglary, a felony."),
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





