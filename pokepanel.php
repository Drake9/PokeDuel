﻿<?php
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
	
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="css/fontello.css">
	<link href="https://fonts.googleapis.com/css?family=Acme|Freckle+Face&amp;subset=latin-ext" rel="stylesheet"> 
</head>

<body>

	<header>

		<h1 class="logo" >PokéDuel</h1>
		
		<div id="menu">
			<?php
			echo '<div class="menutile">'.$_SESSION['user'].'</div>';
			echo '<div class="playerid">'.$_SESSION['playerid'].'</div>';
			echo '<div class="menutile"><a href="playerpanel.php">Players&#39; panel</a></div>';
			echo '<div class="menutile"><a href="pokepanel.php">Poképanel</a></div>';
			echo '<div class="menutile"><a href="socialpanel.php">Play</a></div>';
			echo '<div class="menutile"><a href="logout.php">Log out</a></div>';
			?>
			<div style="clear: both;"></div>
		</div>
	
	</header>
	
	<div id="container">
		
		<div class="sidepanel">
		
		<?php
			for($i=1; $i<7; $i++){
				echo '<div class="pokemonsmall" id="pokemon'.$i.'"></div>';
			}	
		?>
		
		</div>
		
		<main>
			
			<div class="pokemonlarge" id="bigimage"></div>
			
			<div class="description" id="description">
		
			</div>
			
			<div style="clear: both;"></div>
			
			<?php
				for($i=1; $i<7; $i++){
					echo '<div class="attackcard" id="attack'.$i.'"></div>';
					if($i==3)
						echo '<div style="clear: both;"></div>';
				}
			?>
					
		</main>
		
		<div class="sidepanel">
			<div id="menuright">
			</div>
		</div>
		
		<div style="clear: both;">
		</div>
		
	</div>
	<footer>
		Wszelkie prawa zastrzeżone &copy; 2017 Dziękuję za wizytę!
	</footer>
	
	<?php
	echo "<script src='jquery-3.2.1.min.js'></script>";
	echo "<script src='pokepanel.js'></script>";
	?>
	
</body>
</html>