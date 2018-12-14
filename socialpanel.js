var playerid=$("div.playerid").html();
var nick=$("div.nick").html();
var pokeData, attacks, attackdex;
var focused=1;
var selected=1;
var rightpanel = 'attacks';
var menuright = document.getElementById('menuright');
var button = document.getElementById('description');
var usersOnline;
var receivedMessage;

var socket;

var enemyid=3;

$(function() {
	start();
});

//button.addEventListener("click", function() { start(); });

function start() {
    var host = "ws://127.0.0.1:9000/"; // nasz adres serwera
    socket = new WebSocket(host);
	
    // zaraz po nawiązaniu połączenia wysyłamy wiadomość
    socket.onopen = function(msg) {
        console.log("Connected, status "+this.readyState);
        socket.send("Connected: "+nick);
    };
	
	//po otrzymaniu wiadomości wypisujemy ją w konsoli
    socket.onmessage = function(msg) {
		receivedMessage = msg.data
        console.log("Received: " + receivedMessage); 
		if(receivedMessage.charAt(0)=="{"){
			viewUsersOnline(receivedMessage);
		}
		else if(receivedMessage.charAt(0)=="C"){
			viewNewChallenge(receivedMessage);
		}
		else if(receivedMessage.charAt(0)=="D"){
			updateChallenges(receivedMessage);
		}
		else if(receivedMessage.charAt(0)=="G"){
			goToGame(receivedMessage);
		}
			
    };
	
}

//funkcja zamykająca połączenie po wyjściu ze strony
$(window).on('beforeunload' , function(){
	socket.send("Disconnected: "+nick);
	socket.close();
	// logujemy zamknięcie połączenia
    socket.onclose  = function(msg) {
        console.log("Disconnected, status "+this.readyState);
    };
});

$('#menuleft').on('click', 'div', function() { 
	socket.send("Challenged: "+nick+" challenged "+$(this).html());
	});
	
$('#menuright').on('click', 'div', function() { 
	socket.send("Match: "+nick+" vs "+$(this).html());
	});

function viewUsersOnline(data) {
	data = JSON.parse(data);
	$('#menuleft').empty();
	
	var length = Object.keys(data).length;
	for(index = 1; index<= length; index++){
		if((data[index] != null) && (data[index] != nick))
			$('#menuleft').append('<div class="attacksmall" id="lefttile'+index+'">'+data[index]+'</div>');
	}
	
}

function viewNewChallenge(data){
	
	var words = data.split(" ");
	
	$('#menuright').append('<div class="attacksmall" id="'+words[2]+'">'+words[2]+'</div>');
}

function updateChallenges(data){
	var words = data.split(" ");
	var disconnected = words[1];
	
	$('#'+disconnected).remove();
}

function goToGame(data){
	window.location.assign("game.php")
}