var playerid = $("div.playerid").html();

var menuright = document.getElementById('menuright');
var img = document.getElementById('bigimage');
var playerData;


$(function() {
	loadPlayerData(playerid);
});

function loadPlayerData(playerid){
	var data ={'playerid': playerid};
	$.ajax({
		url : 'ajaxplayerdata.php',
		data : data,
		type : 'POST',
		dataType : 'text',
	  
		success : function(json) {
			console.log("Received: "+json);
			playerData = JSON.parse(json);
			insertPlayerData(playerData);
		},
	  
		error : function(xhr, status) {
			alert('Przepraszamy, wystąpił problem! (ajaxplayerdata)');
		},
		
	});
}

function insertPlayerData(playerData){
	$('#paragraph1').html("Playing since: "+playerData.since+"<br>Games won: "+playerData.wins);

}