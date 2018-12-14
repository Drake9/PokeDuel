var playerid=$("div.playerid").html();
var nick=$("div.nick").html();
var colorNormal = "#A8A77A",	colorFire = "#EE8130", 		colorWater = "#6390F0", 	colorElectric = "#F7D02C";
var colorGrass = "#7AC74C",		colorIce = "#96D9D6", 		colorFighting = "#C22E28", 	colorPoison = "#A33EA1";
var colorGround = "#E2BF65", 	colorFlying = "#A98FF3", 	colorPsychic = "#F95587",	colorBug = "#A6B91A";
var colorRock = "#B6A136", 		colorGhost = "#735797", 	colorDragon = "#6F35FC", 	colorDark = "#705746";
var colorSteel = "#B7B7CE", 	colorFairy = "#D685AD";

var receivedMessage;

var socket;

var myPokemons = [], opPokemons = [], myCards = [];
var opVisibles = [false, false, false, false, false, false, false];

var myActivePokemon = 0, opActivePokemon = 0;
var myTurn = false;
var reacted = false;
var cardOnTable = false;
var timer;

$(function() {
	$( "#dialog" ).dialog({
       autoOpen: false,
	});
	start();
});

$("#attack1").on("mouseover", function() {focusCard(1); } );
$("#attack2").on("mouseover", function() {focusCard(2); } );
$("#attack3").on("mouseover", function() {focusCard(3); } );
$("#attack4").on("mouseover", function() {focusCard(4); } );
$("#attack5").on("mouseover", function() {focusCard(5); } );

$("#attack1").on("mouseout", function() {unfocusCard(1); } );
$("#attack2").on("mouseout", function() {unfocusCard(2); } );
$("#attack3").on("mouseout", function() {unfocusCard(3); } );
$("#attack4").on("mouseout", function() {unfocusCard(4); } );
$("#attack5").on("mouseout", function() {unfocusCard(5); } );
//$("#attack6").on("mouseout", function() {$('#hints').empty(); } );

$("#attack1").on("click", function() { playCard(1); } );
$("#attack2").on("click", function() { playCard(2); } );
$("#attack3").on("click", function() { playCard(3); } );
$("#attack4").on("click", function() { playCard(4); } );
$("#attack5").on("click", function() { playCard(5); } );

$("#switch").on("click", function() { switchPokemon(); } );
$("#continue").on("click", function() { continueAttack(); } );
$("#pass").on("click", function() { passYourTurn(); } );
$("#concede").on("click", function() { concedeMatch(); } );

$('#discard1').on("click", function() { discardCard(1); } );
$('#discard2').on("click", function() { discardCard(2); } );
$('#discard3').on("click", function() { discardCard(3); } );
$('#discard4').on("click", function() { discardCard(4); } );
$('#discard5').on("click", function() { discardCard(5); } );

$("#pokemon1").on("mouseover", function() {loadOpPokemonStats(1); } );
$("#pokemon2").on("mouseover", function() {loadOpPokemonStats(2); } );
$("#pokemon3").on("mouseover", function() {loadOpPokemonStats(3); } );
$("#pokemon4").on("mouseover", function() {loadOpPokemonStats(4); } );
$("#pokemon5").on("mouseover", function() {loadOpPokemonStats(5); } );
$("#pokemon6").on("mouseover", function() {loadOpPokemonStats(6); } );
$("#pokemon7").on("mouseover", function() {loadMyPokemonStats(1); } );
$("#pokemon8").on("mouseover", function() {loadMyPokemonStats(2); } );
$("#pokemon9").on("mouseover", function() {loadMyPokemonStats(3); } );
$("#pokemon10").on("mouseover", function() {loadMyPokemonStats(4); } );
$("#pokemon11").on("mouseover", function() {loadMyPokemonStats(5); } );
$("#pokemon12").on("mouseover", function() {loadMyPokemonStats(6); } );

$("#pokemon1").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon2").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon3").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon4").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon5").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon6").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon7").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon8").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon9").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon10").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon11").on("mouseout", function() {$('#hints').empty(); } );
$("#pokemon12").on("mouseout", function() {$('#hints').empty(); } );

$("#pokemon7").on("click", function() {clickPokemon(1); } );
$("#pokemon8").on("click", function() {clickPokemon(2); } );
$("#pokemon9").on("click", function() {clickPokemon(3); } );
$("#pokemon10").on("click", function() {clickPokemon(4); } );
$("#pokemon11").on("click", function() {clickPokemon(5); } );
$("#pokemon12").on("click", function() {clickPokemon(6); } );

//$('#bigimage1').on("click", function() { shake() } );

function start() {
    var host = "ws://127.0.0.1:9000/"; // nasz adres serwera
    socket = new WebSocket(host);
	
    // zaraz po nawiązaniu połączenia wysyłamy wiadomość
    socket.onopen = function(msg) {
        console.log("Connected, status "+this.readyState);
        socket.send("Player GameDataRequest: "+nick);
	};
	
	//po otrzymaniu wiadomości wypisujemy ją w konsoli
    socket.onmessage = function(msg) {
		receivedMessage = msg.data
        console.log("Received: " + receivedMessage); 
		var words = receivedMessage.split("/");
		var keyword = words[0];
		
		switch(keyword){
			case "Opponent:":
				loadOppNick(words);
				break;
			case "Card:":
				loadCard(words);
				break;
			case "Cards left:":
				loadCardsLeft(words);
				break;
			case "OpCards left:":
				loadOpCardsLeft(words);
				break;
			case "Weather:":
				showWeather(words);
				break;
			case "Pokemon:":
				loadMyPokemon(words);
				break;
			case "OpPokemon:":
				loadOpPokemon(words);
				break;
			case "Choose your Pokemon!":
				highlightMyPokemons();
				break;
			case "Your opponent is choosing Pokemon.":
				showOppSwitchingOut();
				break;
			case "Your active Pokemon:":
				loadMyChosenPokemon(words);
				break;
			case "Opponent active Pokemon:":
				loadOpChosenPokemon(words);
				break;
			case "Your turn!":
				showMyTurn();
				break;
			case "Opponent's turn!":
				showOpTurn();
				break;
			case "Opponent's move:":
				showIncomingAttack(words);
				break;
			case "Attack:":
				showAttack(words);
				break;
			case "Game over!":
				showGameOver(words);
				break;
			case "RPS Request!":
				showRPSDialog();
				break;
			case "Continue:":
				supportContinueButton(words);
				break;
			default:
				showWholeMessage(receivedMessage);
				break;
		}
			
    };
}

//funkcja zamykająca połączenie po wyjściu ze strony
$(window).on('beforeunload' , function(){
	socket.send("Player DisconnectedInGame: "+nick);
	socket.close();
	// logujemy zamknięcie połączenia
    socket.onclose   = function(msg) {
        console.log("Disconnected, status "+this.readyState);
    };
});

function showWholeMessage(data){
	$('#topright').empty();
	$('#topright').html(data);
}	

function loadOppNick(words){
	$('#nick').append(" vs "+words[1]);
}

function loadMyPokemon(words){
	var number = words[1];
	var data = words[2];
	data = JSON.parse(data);
	myPokemons[number] = data;
	$('#pokemon'+(6+Number(number))).css('background-image', 'url(img/'+data.pokeName+'.jpg)');
	
	if(data.currentHP == "0")
		$('#pokemon'+(6+Number(number))).removeClass("pokemonsmallActive").addClass("pokemonsmall").addClass("grayscale");
	else
		$('#pokemon'+(6+Number(number))).removeClass("pokemonsmallActive").addClass("pokemonsmall");
	
}

function loadOpPokemon(words){
	var number = Number(words[1]);
	opVisibles[number] = true;
	var data = words[2];
	data = JSON.parse(data);
	opPokemons[number] = data;
	$('#pokemon'+number).css('background-image', 'url(img/'+data.pokeName+'.jpg)');
	if(data.currentHP == 0)
		$('#pokemon'+number).removeClass("pokemonsmallActive").addClass("pokemonsmall").addClass("grayscale");
	else
		$('#pokemon'+number).removeClass("pokemonsmallActive").addClass("pokemonsmall");
}

function loadCard(words){
	
	var number = Number(words[1]);
	var data = words[2];
	if(data == "no card"){
		myCards[number] = "blank card";
		$('#attack'+number).html("PokéDuel");
		$('#card'+number).removeClass('card').addClass('cardback');
		$('#card'+number).css('background-color', 'black');
		$('#card'+number).css('color', 'orange');
	}
	else{
		data = JSON.parse(data);
		myCards[number] = data;
		
		$('#card'+number).removeClass('cardback').addClass('card');
		$('#attack'+number).html("<b>"+data.attackName+"</b><br><br>");
		for(var index=1; index <= data.attackCost; index++)
			$('#attack'+number).append('<i class="icon-flash yellow"></i>');
		
		$('#attack'+number).append('<br><br>');
		
		if(data.attackCategory == "PA")
			for(var index=1; index <= data.attackPower; index++)
				$('#attack'+number).append('<i class="icon-star saddleBrown"></i>');
			
		else if(data.attackCategory == "SA")
			for(var index=1; index <= data.attackPower; index++)
				$('#attack'+number).append('<i class="icon-star powderBlue"></i>');
			
		switchBackgroundColor($('#card'+number), data.attackType);
	}
}

function loadCardsLeft(words){
	$('#MyCardsLeft').html("You: "+words[1]);
}

function loadOpCardsLeft(words){
	$('#OpCardsLeft').html("Opp: "+words[1]);
}

function showWeather(words){
	var weather = words[1];
	$('#back1').html("Weather:<br><br>"+weather);
	$('#back1').css('line-height', 'normal');
}
	
function switchBackgroundColor(item, type){
	switch(type){
		case "normal":
			$(item).css('background-color', colorNormal);
			$(item).css('color', 'white');
			break;
		case "fire":
			$(item).css('background-color', colorFire);
			$(item).css('color', 'white');
			break;
		case "water":
			$(item).css('background-color', colorWater);
			$(item).css('color', 'white');
			break;
		case "electric":
			$(item).css('background-color', colorElectric);
			$(item).css('color', 'black');
			break;
		case "grass":
			$(item).css('background-color', colorGrass);
			$(item).css('color', 'white');
			break;
		case "ice":
			$(item).css('background-color', colorIce);
			$(item).css('color', 'black');
			break;
		case "fighting":
			$(item).css('background-color', colorFighting);
			$(item).css('color', 'white');
			break;
		case "poison":
			$(item).css('background-color', colorPoison);
			$(item).css('color', 'white');
			break;
		case "ground":
			$(item).css('background-color', colorGround);
			$(item).css('color', 'white');
			break;
		case "flying":
			$(item).css('background-color', colorFlying);
			$(item).css('color', 'white');
			break;
		case "psychic":
			$(item).css('background-color', colorPsychic);
			$(item).css('color', 'white');
			break;
		case "bug":
			$(item).css('background-color', colorBug);
			$(item).css('color', 'white');
			break;
		case "rock":
			$(item).css('background-color', colorRock);
			$(item).css('color', 'white');
			break;
		case "ghost":
			$(item).css('background-color', colorGhost);
			$(item).css('color', 'white');
			break;
		case "dragon":
			$(item).css('background-color', colorDragon);
			$(item).css('color', 'white');
			break;
		case "dark":
			$(item).css('background-color', colorDark);
			$(item).css('color', 'white');
			break;
		case "steel":
			$(item).css('background-color', colorSteel);
			$(item).css('color', 'black');
			break;
		case "fairy":
			$(item).css('background-color', colorFairy);
			$(item).css('color', 'white');
			break;
	}
}

function focusCard(number){
	if(myCards[number] != "blank card"){
		$('#hints').html(myCards[number].attackDescription);
		//$('#attack'+number).append('<i class="icon-cancel-circled discard" id="discard'+number+'"></i>');
	}
}

function unfocusCard(number){
	$('#hints').empty();
	//$('#discard'+number).remove();
}

function discardCard(number){
	if(myTurn == true){
		socket.send("Player DiscardRequest: "+nick+" "+number);
	}
}
	
function loadMyPokemonStats(number){
	loadPokemonStats("me", number);
}

function loadOpPokemonStats(number){
	if(opVisibles[number] == true){
		loadPokemonStats("opp", number);
	}
}

function loadPokemonStats(player, number){
	if(player == "me")
		var data = myPokemons[number];
	else if(player == "opp")
		var data = opPokemons[number];
	
	if(data.typeSecondary){
		$('#hints').html("#"+data.pokeNumber+" <b>"+data.pokeName+'</b><br><div class="type" id="typeprim">'+data.typePrimary+'</div><div class="type">&#160 / &#160</div><div class="type" id="typesec">'+data.typeSecondary+'</div><br>');
		switchBackgroundColor($('#typeprim'), data.typePrimary);
		switchBackgroundColor($('#typesec'), data.typeSecondary);
	}
	else{
		$('#hints').html("#"+data.pokeNumber+" <b>"+data.pokeName+'</b><br><div class="type" id="typeprim">'+data.typePrimary+'</div><br>');
		switchBackgroundColor($('#typeprim'), data.typePrimary);
	}
	
	$('#hints').append('<i class="icon-heart red"></i> '+data.currentHP+" / "+data.maxHP+' &#160 &#160 <i class="icon-flash yellow"></i>'+data.currentEnergy+' &#160 &#160 <i class="icon-forward green"></i> '+data.speed+'<br><i class="icon-star saddleBrown"></i> '+data.attack+' &#160 &#160 <i class="icon-star powderBlue"></i> '+data.specialAttack+'<br><i class="icon-shield saddleBrown"></i> '+data.defence+' &#160 &#160 <i class="icon-shield powderBlue"></i> '+data.specialDefence+'<br>');
	
	if(data.poisoned)
		$('#hints').append("poisoned ");
	if(data.burned)
		$('#hints').append("burned ");
	if(data.confused)
		$('#hints').append("confused ");
	if(data.paralyzed)
		$('#hints').append("paralyzed ");
	if(data.sleeping)
		$('#hints').append("sleeping ");
	if(data.trapped)
		$('#hints').append("trapped ");
	if(data.frozen)
		$('#hints').append("frozen ");
	if(data.hidden)
		$('#hints').append("hidden ");
	if(data.exhausted)
		$('#hints').append("exhausted ");
	if(data.seeded)
		$('#hints').append("seeded ");
	if(data.seeding)
		$('#hints').append("seeding ");
}

function highlightMyPokemons(){
	if(myActivePokemon != 0)
		fadeOutDown(2);
	$('#bottomleft').addClass("sidepanelHighlighted");
	$('#pokemon'+(myActivePokemon+6)).removeClass("pokemonsmallActive").addClass("pokemonsmall");
	$('#topright').html("Choose your Pokémon!");
	myActivePokemon = 0;
}

function lowlightMyPokemons(){
	$('#bottomleft').removeClass("sidepanelHighlighted");
	$('#topright').empty();
}

function showOppSwitchingOut(){
	if(opActivePokemon != 0){
		$('#pokemon'+opActivePokemon).removeClass("pokemonsmallActive").addClass("pokemonsmall");
		fadeOutUp(1);
		opActivePokemon = 0;
	}
}

function clickPokemon(number){
	if(myActivePokemon == 0){
		choosePokemon(number);
	}
}

function switchPokemon(){
	if(myTurn == true){
		socket.send("Player SwitchPokemonRequest: "+nick);
		number = myActivePokemon;
	}
}

function passYourTurn(){
	if(myTurn == true){
		socket.send("Player PassTurnRequest: "+nick);
	}
}

function continueAttack(){
	if(myTurn == true && cardOnTable == true){
		socket.send("Player ContinueRequest: "+nick);
	}
}

function concedeMatch(){
	if(myTurn == true){
		socket.send("Player ConcedeRequest: "+nick);
	}
}

function choosePokemon(number){
	socket.send("Player Chosen: "+nick+" have chosen "+number+" "+myPokemons[number].pokeName);
}

function loadMyChosenPokemon(words){
	$('#bigimage2').css('background-image', 'url(img/'+words[2]+'.jpg)');
	
	if(myActivePokemon == 0)
		fadeInUp(2);
	
	var number = Number(words[1]);
	myActivePokemon = number;
	$('#pokemon'+(6+number)).removeClass("pokemonsmall").addClass("pokemonsmallActive");
	lowlightMyPokemons();
	insertMyPokemonToDescription();
}

function loadOpChosenPokemon(words){
	$('#bigimage1').css('background-image', 'url(img/'+words[2]+'.jpg)');
	
	if(opActivePokemon == 0)
		fadeInDown(1);
	
	opActivePokemon = Number(words[1]);
	
	$('#pokemon'+opActivePokemon).removeClass("pokeballsmall").addClass("pokemonsmallActive");
	insertOpPokemonToDescription();
}

function insertMyPokemonToDescription(){
	insertPokemonToDescription(2);
}

function insertOpPokemonToDescription(){
	insertPokemonToDescription(1);
}

function insertPokemonToDescription(number){
	if(number == 2)
		var data = myPokemons[myActivePokemon];
	else
		var data = opPokemons[opActivePokemon];
	
	if(data.typeSecondary){
		$('#description'+number).html("#"+data.pokeNumber+" <b>"+data.pokeName+'</b><br><div class="type" id="typeprim'+number+'">'+data.typePrimary+'</div><div class="type">&#160 / &#160</div><div class="type" id="typesec'+number+'">'+data.typeSecondary+'</div><br>');
		switchBackgroundColor($('#typeprim'+number), data.typePrimary);
		switchBackgroundColor($('#typesec'+number), data.typeSecondary);
	}
	else{
		$('#description'+number).html("#"+data.pokeNumber+" <b>"+data.pokeName+'</b><br><div class="type" id="typeprim'+number+'">'+data.typePrimary+'</div><br>');
		switchBackgroundColor($('#typeprim'+number), data.typePrimary);
	}
	
	$('#description'+number).append('<i class="icon-heart red"></i> '+data.currentHP+" / "+data.maxHP+' &#160 &#160 <i class="icon-flash yellow"></i>'+data.currentEnergy+' &#160 &#160 <i class="icon-forward green"></i> '+data.speed+'<br><i class="icon-star saddleBrown"></i> '+data.attack+' &#160 &#160 <i class="icon-star powderBlue"></i> '+data.specialAttack+'<br><i class="icon-shield saddleBrown"></i> '+data.defence+' &#160 &#160 <i class="icon-shield powderBlue"></i> '+data.specialDefence+'<br>');
	
	if(data.poisoned)
		$('#description'+number).append("poisoned ");
	if(data.burned)
		$('#description'+number).append("burned ");
	if(data.confused)
		$('#description'+number).append("confused ");
	if(data.paralyzed)
		$('#description'+number).append("paralyzed ");
	if(data.sleeping)
		$('#description'+number).append("sleeping ");
	if(data.trapped)
		$('#description'+number).append("trapped ");
	if(data.frozen)
		$('#description'+number).append("frozen ");
	if(data.hidden)
		$('#description'+number).append("hidden ");
	if(data.exhausted)
		$('#description'+number).append("exhausted ");
	if(data.seeded)
		$('#description'+number).append("seeded ");
	if(data.seeding)
		$('#description'+number).append("seeding ");
}

function showMyTurn(){
	myTurn = true;
	$('#topright').html("<b>It's your turn!</b>");
	$('#myPokAndCards').addClass("sideHighlighted");
	$('#enemyPokAndCards').removeClass("sideHighlighted");
}

function showOpTurn(){
	myTurn = false;
	reacted = false;
	$('#topright').html("<b>It's your opponent's turn!</b>");
	$('#enemyPokAndCards').addClass("sideHighlighted");
	$('#myPokAndCards').removeClass("sideHighlighted");
}

function playCard(number){
	var cardKeywords = myCards[number].attackKeywords;
	var cardType = myCards[number].attackType;
	var cardSignature = myCards[number].attackSignature;
	var myBro = myPokemons[myActivePokemon];
	
	
	if(myTurn == true){
		if(!(myBro.typePrimary == cardType || myBro.typeSecondary == cardType || cardType == "normal" || myBro.pokeName == cardSignature)){
			$('#topright').empty();
			$('#topright').html("Your Pokémon can't use this move.");
		}
		else if(myBro.currentEnergy < myCards[number].attackCost){
			$('#topright').empty();
			$('#topright').html("Your Pokémon is too tired to use this move.");
		}
		else{
			$('#card'+number).addClass('cardPlayed');
			setTimeout(function(){ $('#card'+number).removeClass('cardPlayed'); socket.send("Player CardPlayed: "+nick+" "+number);}, 500);
		}
	}
	else if(reacted == false){
		if(!(myBro.typePrimary == cardType || myBro.typeSecondary == cardType || cardType == "normal" || myBro.pokeName == cardSignature)){
			$('#topright').empty();
			$('#topright').html("Your Pokémon can't use this move.");
		}
		else if(myBro.currentEnergy < myCards[number].attackCost){
			$('#topright').empty();
			$('#topright').html("Your Pokémon is too tired to use this move.");
		}
		/*else if(myBro.speed < opPokemons[opActivePokemon].speed){
			$('#topright').empty();
			$('#topright').html("Your Pokémon is too slow to do this.");
		}*/
		else if(!(cardKeywords.includes("quick") || cardKeywords.includes("react"))){
			$('#topright').empty();
			$('#topright').html("You can't use this in opponent's turn.");
		}
		else{
			clearTimeout(timer);
			reacted = true;
			socket.send("Player Response: "+nick+" "+number);
		}
	}
}

function showIncomingAttack(words){
	$('#topright').empty();
	$('#topright').html(words[1]);
	timer = setTimeout(function(){ socket.send("Player Response: "+nick+" "+0); }, 3000);
}

function showGameOver(words){
	$('#dialog').dialog("open");
	ShowGameEndBox(words[1], words[2], 'GoToAssetList', null);
}

function showRPSDialog(){
	
	timer = setTimeout(function(){ socket.send("Player RPS: "+nick+" none"); $("#dialog").dialog('close'); }, 5000);
	$('#dialog').dialog("open");
	ShowDialogBox('Rock-Paper-Scissors request!', 'Choose one: ', 'rock', 'paper', 'scissors', 'GoToAssetList', null);
}

function supportContinueButton(words){
	if(words[1]=="true"){
		$('#continue').removeClass('buttonInactive').addClass('button');
		cardOnTable = true;
	}
	else{
		$('#continue').removeClass('button').addClass('buttonInactive');
		cardOnTable = false;
	}
}

function showAttack(words){
	if(words[2] != '0')
		shakePokemon(words[1]);
	pulsePokemon(3 - words[1]);
	showWholeMessage(words[3]);
}

function ShowDialogBox(title, content, btn1text, btn2text, btn3text, functionText, parameterList) {
	var btn1css;
	var btn2css;
	var btn3css;

	if (btn1text == '') {
		btn1css = "hidecss";
	} else {
		btn1css = "showcss";
	}

	if (btn2text == '') {
		btn2css = "hidecss";
	} else {
		btn2css = "showcss";
	}
	
	if (btn3text == '') {
		btn3css = "hidecss";
	} else {
		btn3css = "showcss";
	}
	
	$("#lblMessage").html(content);

	$("#dialog").dialog({
		resizable: false,
		title: title,
		modal: true,
		width: '400px',
		height: 'auto',
		bgiframe: false,
		hide: { effect: 'scale', duration: 400 },

		buttons:[
			{
				text: btn1text,
				"class": btn1css,
				click: function () {										
					$("#dialog").dialog('close');
					socket.send("Player RPS: "+nick+" "+btn1text);
					clearTimeout(timer);
				}
			},
			{
				text: btn2text,
				"class": btn2css,
				click: function () {
					$("#dialog").dialog('close');
					socket.send("Player RPS: "+nick+" "+btn2text);
					clearTimeout(timer);
				}
			},
			{
				text: btn3text,
				"class": btn2css,
				click: function () {
					$("#dialog").dialog('close');
					socket.send("Player RPS: "+nick+" "+btn3text);
					clearTimeout(timer);
				}
			}
		]
		
	});
}

function ShowGameEndBox(title, content, functionText, parameterList) {
	var btn1css = "showcss";
	var btn1text = "OK";
	$("#lblMessage").html(content);

	$("#dialog").dialog({
		resizable: false,
		title: title,
		modal: true,
		width: '400px',
		height: 'auto',
		bgiframe: false,
		hide: { effect: 'scale', duration: 400 },

		buttons:[
			{
				text: btn1text,
				"class": btn1css,
				click: function () {										
					$("#dialog").dialog('close');
					window.location.replace("playerpanel.php");
				}
			}
		]
		
	});
}

function shakePokemon(number){
	$('#bigimage'+number).addClass("shake");
	setTimeout(function(){ $('#bigimage'+number).removeClass("shake"); }, 1500);
}

function pulsePokemon(number){
	$('#bigimage'+number).addClass("pulse");
	setTimeout(function(){ $('#bigimage'+number).removeClass("pulse"); }, 1500);
}

function fadeInUp(number){
	$('#bigimage'+number).addClass("fadeInUp");
	setTimeout(function(){ $('#bigimage'+number).removeClass("fadeInUp"); }, 1500);
}

function fadeInDown(number){
	$('#bigimage'+number).addClass("fadeInDown");
	setTimeout(function(){ $('#bigimage'+number).removeClass("fadeInDown"); }, 1500);
}

function fadeOutUp(number){
	$('#bigimage'+number).addClass("fadeOutUp");
	setTimeout(function(){ $('#bigimage'+number).removeClass("fadeOutUp").css('background-image', 'none'); }, 1500);
}

function fadeOutDown(number){
	$('#bigimage'+number).addClass("fadeOutDown");
	setTimeout(function(){ $('#bigimage'+number).removeClass("fadeOutDown").css('background-image', 'none'); }, 1500);
}