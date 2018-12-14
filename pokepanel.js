var playerid=$("div.playerid").html();
var pokeData, attacks, attackdex;
var focused=1;
var selected=1;
var rightpanel = 'attacks';
var menuright = document.getElementById('menuright');
var img = document.getElementById('bigimage');

var colorNormal = "#A8A77A",	colorFire = "#EE8130", 		colorWater = "#6390F0", 	colorElectric = "#F7D02C";
var colorGrass = "#7AC74C",		colorIce = "#96D9D6", 		colorFighting = "#C22E28", 	colorPoison = "#A33EA1";
var colorGround = "#E2BF65", 	colorFlying = "#A98FF3", 	colorPsychic = "#F95587",	colorBug = "#A6B91A";
var colorRock = "#B6A136", 		colorGhost = "#735797", 	colorDragon = "#6F35FC", 	colorDark = "#705746";
var colorSteel = "#B7B7CE", 	colorFairy = "#D685AD";

var pokemon1 = document.getElementById('pokemon1');
var pokemon2 = document.getElementById('pokemon2');
var pokemon3 = document.getElementById('pokemon3');
var pokemon4 = document.getElementById('pokemon4');
var pokemon5 = document.getElementById('pokemon5');
var pokemon6 = document.getElementById('pokemon6');

var attack1 = document.getElementById('attack1');
var attack2 = document.getElementById('attack2');
var attack3 = document.getElementById('attack3');
var attack4 = document.getElementById('attack4');
var attack5 = document.getElementById('attack5');
var attack6 = document.getElementById('attack6');

pokemon1.addEventListener("click", function() { focusPokemon(1); });
pokemon2.addEventListener("click", function() { focusPokemon(2); });
pokemon3.addEventListener("click", function() { focusPokemon(3); });
pokemon4.addEventListener("click", function() { focusPokemon(4); });
pokemon5.addEventListener("click", function() { focusPokemon(5); });
pokemon6.addEventListener("click", function() { focusPokemon(6); });

attack1.addEventListener("click", function() { selectAttack(1); });
attack2.addEventListener("click", function() { selectAttack(2); });
attack3.addEventListener("click", function() { selectAttack(3); });
attack4.addEventListener("click", function() { selectAttack(4); });
attack5.addEventListener("click", function() { selectAttack(5); });
attack6.addEventListener("click", function() { selectAttack(6); });

$(menuright).on('click', 'div', function() { 
	if(rightpanel=='attacks'){
		replaceAttack(playerid, focused, selected, $(this).html());
	}
	else if(rightpanel=='pokelist'){
		changePokemon(playerid, focused, $(this).html());
	}
	});
	
$(img).on('click', function() { getPokeList(); });


$(function() {
	loadPokeData(playerid);
});

function loadPokeData(playerid){
	getPokeData(playerid);
	getAttacks(playerid);
}

function getPokeData(playerid){
	var data ={'playerid': playerid};
	$.ajax({
		url : 'ajaxpokemons.php',
		data : data,
		type : 'POST',
		dataType : 'text',
	  
		success : function(json) {
			console.log("Received: "+json);
			pokeData=JSON.parse(json);
			loadDescription(pokeData,focused);
			loadLeftPanel(pokeData);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajax1)');
		},
	  
		/*complete : function(xhr, status) {
			alert('Żądanie wykonane!');
		}*/
		
	});
}

function getAttacks(playerid){
	var data ={'playerid': playerid};
	$.ajax({
		url : 'ajaxattacks.php',
		data : data,
		type : 'POST',
		dataType : 'text',
	  
		success : function(json) {
			attacks=JSON.parse(json);
			loadAttacks(attacks,focused);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajax2)');
		},
	  
	});
}

function loadDescription(data,i){
	$('#description').html('#'+data[i].pokenumber+' '+data[i].name+" - "+data[i].species+'</br> <div class="type" id="typeprim">'+data[i].typeprim+"</div>");
	switchBackgroundColor($('#typeprim'), data[i].typeprim);
	
	if(data[i].typesec){
		$('#description').append('<div class="type">&nbsp/&nbsp</div><div class="type" id="typesec">'+data[i].typesec+"</div>");
		switchBackgroundColor($('#typesec'), data[i].typesec);
	}
	
	$('#description').append('</br>height: '+data[i].height+" m</br>weight: "+data[i].weight+' kg</br><i class="icon-heart red"></i>'+(Number(data[i].hp)*2+6)+'&nbsp&nbsp <i class="icon-star saddleBrown"></i>'+data[i].attack+'&nbsp&nbsp <i class="icon-shield saddleBrown"></i>'+data[i].defence+'<br/><i class="icon-forward green"></i>'+data[i].speed+'&nbsp&nbsp <i class="icon-star powderBlue"></i>'+data[i]['specattack']+'&nbsp&nbsp <i class="icon-shield powderBlue"></i>'+data[i].specdefence);
	
	$('#bigimage').css('background-image', 'url(img/'+data[i].name+'.jpg)');
}

function loadLeftPanel(data){
	for(i=1; i<7; i++){
		$('#pokemon'+i).html('#'+data[i].pokenumber+'<br>'+data[i].name);
		if(i==focused)
			$('#change'+i).addClass('focusedchange');
		$('#pokemon'+focused).addClass('focusedpokemonsmall');
	}
}

function loadAttacks(attacks,i){
	i=(i-1)*6;
	var k=0;
	for(j=1; j<7; j++){
		k=i+j;
		$('#attack'+j).html('<div class="type" id="name'+j+'">'+attacks[k].attackname+'</div></br>');
		
		for(var n=1; n<= attacks[k].cost; n++)
			$('#attack'+j).append('<i class="icon-flash yellow"></i>');
		$('#attack'+j).append('<br/>');
		
		if(attacks[k].category == "PA")
			for(var n=1; n<= attacks[k].power; n++)
				$('#attack'+j).append('<i class="icon-star saddleBrown"></i>');
			
		else if(attacks[k].category == "SA")
			for(var n=1; n<= attacks[k].power; n++)
				$('#attack'+j).append('<i class="icon-star powderBlue"></i>');
			
		$('#attack'+j).append('<br/>'+attacks[k].description);
		
		switchBackgroundColor($('#name'+j), attacks[k].type);
	}
	//selectAttack(1);
}

function focusPokemon(nr){
	rightpanel = 'attacks';
	$('#pokemon'+focused).removeClass('focusedpokemonsmall');
	$('#change'+focused).removeClass('focusedchange');
	focused=nr;
	$('#pokemon'+focused).addClass('focusedpokemonsmall');
	$('#change'+focused).addClass('focusedchange');
	loadAttacks(attacks,nr);
	loadDescription(pokeData,nr);
	showPossibleAttacks(nr);
}

function showPossibleAttacks(nr){
	$('#menuright').empty();
	getPossibleAttacks(nr);
}

function getPossibleAttacks(nr){
	var types ={'name': pokeData[nr].name, 'typeprim': pokeData[nr].typeprim, 'typesec': pokeData[nr].typesec};
	
	$.ajax({
		url : 'ajaxattackdex.php',
		data : types,
		type : 'POST',
		dataType : 'text',
	  
		success : function(json) {
			attackdex=JSON.parse(json);
			loadAttackdex(attackdex);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajax3)');
		},
		
	});
}

function loadAttackdex(attackdex){
	$(img).css('background-color', 'dimgray');
	rightpanel = 'attacks';
	var index=1;
	while(attackdex[index]){
		$('#menuright').append('<div class="attacksmall" id="righttile'+index+'">'+attackdex[index].attackname+'</div>');
		switchBackgroundColor($('#righttile'+index), attackdex[index].type);
		index++;
	}
}

function selectAttack(nr){
	if(rightpanel == "pokelist"){
		showPossibleAttacks(focused);
	}
	
	$('#attack'+selected).removeClass('selectedattackcard');
	selected = nr;
	$('#attack'+selected).addClass('selectedattackcard');
}

function replaceAttack(playernr, pokenr, attacknr, wanted){
	var i=1;
	while(attackdex[i].attackname!=wanted){
		i++;
	}
	wanted = attackdex[i].id;
	var data={'playerid': playernr, 'focused': pokeData[pokenr].id, 'selected': attacknr, 'wanted': wanted};
	
	$.ajax({
		url : 'ajaxattackchange.php',
		data : data,
		type : 'POST',
		dataType : 'text',
	  
		success : function() {
			loadPokeData(playerid);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajax4)');
		},
		
	});
}

function getPokeList(){
	rightpanel = 'pokelist';
	
		$.ajax({
			url : 'ajaxpokedex.php',
			data : 'NULL',
			type : 'POST',
			dataType : 'text',
		  
			success : function(json) {
				var pokedex = JSON.parse(json);
				loadPokeList(pokedex);
			},
		  
			error : function(xhr, status) {
				alert('Przepraszamy, wystąpił problem! (ajax5)');
			},
			
		});
}

function loadPokeList(data){
	$('#menuright').empty();
	$(img).css('background-color', 'black');
	var index=1;
	while(data[index]){
		$('#menuright').append('<div class="attacksmall" id="righttile'+i+'">#'+data[index].number+' '+data[index].name+'</div>');
		index++;
	}
}

function changePokemon(playernr, pokenr, wanted){
	var index = 1;
	while(wanted.charAt(index)!=" "){
		index++;
	}
	wanted=wanted.substr(1,index-1)
	
	var data={'playerid': playernr, 'focused': pokeData[pokenr].id, 'wanted': wanted};
	
	$.ajax({
		url : 'ajaxpokemonchange.php',
		data : data,
		type : 'POST',
		dataType : 'text',
	  
		success : function() {
			loadPokeData(playerid);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajax6)');
		},
		
	});
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