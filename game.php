<?php
	session_start();

	if(!isset($_SESSION['loggedin'])){
		header('Location: index.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>PokéDuel - gra przeglądarkowa</title>
	
	<link rel="stylesheet" href="game.css">
	<link rel="stylesheet" href="css/fontello.css">
	<link href="https://fonts.googleapis.com/css?family=Acme|Freckle+Face&amp;subset=latin-ext" rel="stylesheet"> 
</head>

<body>

	<header>
		
		<div id="menu">
			<?php
			echo '<div class="nick" id="nick">'.$_SESSION['user'].'</div>';
			echo '<div class="playerid">'.$_SESSION['playerid'].'</div>';
			echo '<div class="menutile"><a href="playerpanel.php">Players&#39; panel</a></div>';
			echo '<div class="menutile"><a href="pokepanel.php">Poképanel</a></div>';
			echo '<div class="menutile"><a href="logout.php">Log out</a></div>';
			?>
			<div style="clear: both;"></div>
		</div>
	
	</header>
	
	<div id="container">
		<main>
	
			<div class="half" id="enemyside">
			
				<div class="sidepanel" id="topleft">
					<?php
						for($i=1; $i<7; $i++){
							echo '<div class="pokeballsmall" id="pokemon'.$i.'"></div>';
							if($i%2==0)
								echo '<div style="clear: both;"></div>';
						}	
					?>
				</div>
				
				<div id="enemyPokAndCards" class="center">
				
					<?php
						for($i=1; $i<5; $i++)
							echo '<div class="cardback" id="back'.$i.'">PokéDuel</div>';
						echo '<div class="cardsLeft" id="back5"><b><div>Decks</div><br><div id="OpCardsLeft">Opp: 31</div><div id="MyCardsLeft"></div></b></div>';
						echo '<div style="clear: both;"></div>';
					?>
				
					<div class="pokemon">
					
						<div class="description" id="description1"></div>
					
						<div class="pokeballlarge" id="bigimage1"></div>
							
						<div style="clear: both;"></div>
						
					</div>
					
				</div>
				
				<div class="sidepanel" id="topright"></div>
				
				<div style="clear: both;"></div>
				
			</div>
			
			<div class="half" id="playerside">
			
			<div id="dialog" title="Alert message" style="display: none">
				<div class="ui-dialog-content ui-widget-content">
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>
						<label id="lblMessage">
						</label>
					</p>
				</div>
			</div>
			
				<div class="sidepanel" id="bottomleft">
					<?php
						for($i=7; $i<13; $i++){
							echo '<div class="pokemonsmall" id="pokemon'.$i.'"></div>';
							if($i%2==0)
								echo '<div style="clear: both;"></div>';
						}	
					?>
				</div>
				
				<div id="myPokAndCards" class="center">
				
					<div class="pokemon">
					
						<div class="pokeballlarge" id="bigimage2"></div>
							
						<div class="description" id="description2"></div>
							
						<div style="clear: both;"></div>
						
					</div>
					
					<?php
						for($i=1; $i<6; $i++)
							echo '<div class="card" id="card'.$i.'"><div class="attack" id="attack'.$i.'"><b><Switch Pokémon</b></div><i class="icon-cancel-circled discard" id="discard'.$i.'"></i></div>';
						echo '<div style="clear: both;"></div>';
					?>
				</div>
				
				<div class="sidepanel" id="bottomright">
					<div id="hints"></div>
					<div class="buttons" id="buttons">
						<button type="button" class="button" id="switch">Switch</button>
						<button type="button" class="buttonInactive" id="continue">Continue</button>
						<br>
						<button type="button" class="button" id="pass">Pass</button>
						<button type="button" class="button" id="concede">Concede</button>
					</div>
				</div>	
				<div style="clear: both;"></div>
			
			</div>
		
		</main>
	</div>
	<footer>
		Wszelkie prawa zastrzeżone &copy; 2017 Dziękuję za wizytę!
	</footer>
	
	<?php
	echo "<script src='jquery-3.2.1.min.js'></script>";
	echo "<script src='jquery-ui.min.js'></script>";
	echo "<script src='game.js'></script>";
	?>
	
</body>
</html>