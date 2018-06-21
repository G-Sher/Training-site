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

    new Question("WHILE YOU ARE ON DUTY AT A SHOPPING CENTER, YOU SEE A 12-YEAR OLD JABBING AN ICE PICK INTO A PATRON'S CAR TIRES. YOU SHOULD FIRST:", 
	["Pick the 12-year old up and throw him/her out of the parking lot.", "Get a good description and call the police.","Run at the 12-year old and yell so the child will run away.", "Approach him/her and tell them to stop."], 
	"Approach him/her and tell them to stop."),
	new Question("A MAN IS SMASHING TABLES AND CHAIRS AT A BAR YOU ARE SECURITY GUARD/PROPRIETARY PRIVATE SECURITY OFFICERING. HE IS ABOUT 6\' 8\" AND WEIGHS 280 LBS. YOU SHOULD:", 
	["Consider your safety and the safety of others.", "Request patrons of the bar to clear the area.","Call the police for assistance.", "Take all of the measures above."], 
	"Take all of the measures above."),
	new Question("YOU ARE SECURITY GUARD/PROPRIETARY PRIVATE SECURITY WORKING IN A JEWELRY STORE AT CLOSING TIME. THE LAST PATRON HAS LEFT AND YOUR EMPLOYER IS ABOUT TO LOCK UP. YOU NOTICE A MAN SITTING IN A CAR AND THE MOTOR IS RUNNING. YOU CLEARLY SEE HE HAS A GUN IN HIS HAND. YOU SHOULD FIRST:", 
	["Run out to the car and tell him to freeze.", "Have the owner call the police and get a description and vehicle license number if possible.","Walk to the car and order the man to leave.", ""], 
	"Have the owner call the police and get a description and vehicle license number if possible."),
	new Question("YOU ARE WORKING AT A CLUB WHERE EVERYTHING IS QUIET. DOWN THE STREET TWO MEN GET INTO A FIGHT. YOU SHOULD:", 
	["Stay where you are. You have been hired to guard the dance. You could call the police if it doesn’t involve leaving your post.", "Call someone over to watch the dance while you go down the street to break up the fight.","Shout down the street for the men to break it up.", ""], 
	"Stay where you are. You have been hired to guard the dance. You could call the police if it doesn’t involve leaving your post."),
	new Question("YOU ARE PATROLLING A SHOPPING AREA WHEN YOU SEE A JUVENILE RIDING A SKATEBOARD. YOU KNOW THAT SKATING IS AGAINST THE MALL POLICY. YOUR BEST COURSE OF ACTION WOULD BE TO:", 
	["Handle the matter formally as a criminal offense.", " Politely approach the boy and inform him of shopping mall policy regarding skating in the mall.","", ""], 
	" Politely approach the boy and inform him of shopping mall policy regarding skating in the mall.")
	];

// create quiz
var quiz = new Quiz(questions);

// display quiz
populate();





