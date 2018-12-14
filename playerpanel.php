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
	
	<link rel="stylesheet" href="playerpanel.css">
	<link href="https://fonts.googleapis.com/css?family=Acme|Freckle+Face&amp;subset=latin-ext" rel="stylesheet"> 
</head>

<body>

	<header>

		<h1 class="logo" >PokéDuel</h1>
		
		<div id="menu">
			<?php
			echo '<div class="nick">'.$_SESSION['user'].'</div>';
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
		
		<div class="sidepanel" id="menuleft">
		
		</div>
		
		<main>
					
			<div class="paragraph" id="paragraph1">

			</div>
			
			<div class="paragraph" id="paragraph2">
				For new or forgetful:
				<br><br>
				In your Poképanel you can pick a team of six Pokémon. Each of them can use attacks of its type (or types) and normal attacks. Sometimes a Pokémon can use an additional signature move, not from its type. Each Pokémon has six slots for attacks. This will guarantee that in game each of your Pokémon will be able to use at least these moves. However, it is recommended for you to match types of two or more Pokémon, so they can use the same attacks.
				<br><br>
				When you enter the game, all your selected moves create one deck. You draw five cards and pick your first Pokémon (the challenging player chooses first). In each of your turns your active Pokémon gain one energy (max: 5) and you draw to five cards. Then you can play a card, pass or continue previous attack.
				<br><br>
				Each Pokémon has its own stats. Health points, for example, are stated near a red heart icon. Speed is listed near a green arrow, attack and defence - brown star and shield, special attack and special defence - blue star and shield. And there is also an energy (lightning icon).
				<br><br>
				You can play a card if your active Pokémon matches its type, represented by color (additionally you can use normal and signature moves), and has enough energy. In general, your active Pokémon's energy is decreased by attack's cost, and your attack's power equals card's power plus Pokémon's attack (or special attack - look on the color of stars on card) power. This is reduced by opponet's defence (or special defence) and somethimes further modified by opponent's weakness or resistance to attack's type. Good Pokémon trainer knows which type is effective against current opponent!
				<br><br>
				They are also a STATUS moves, which do not deal damage. They can change both Pokémon stats or status. Or weather. Some attacks can do it too. And some of them can be used in opponent't turn, but only if your active Pokémon hasn't lower speed that its foe (they are marked with words: quick, dodge or intercept). Some attacks require one-turn loading, some exhaust Pokémon, forcing to pass next turn (or to switch). Some attacks can be used several turns in a row.
				<br><br>
				If you can't use your cards with your current active Pokémon, you can switch. If you pass a turn, your active Pokémon gains one extra energy for resting. If you played loaded or reusable attack, you can click continue button to... em... continue it. But if you played a card in opponent's turn, your previous attack is lost!
				<br><br>
				I've mentioned statuses, right? They are several of them. Poisoned Pokémon loses 0.5 hp at the end of each turn (your and your opponent's). Same with burned and trapped, but being burned means additionally minus one damage to physical attacks and being trapped means unable to switch (trap can be removed by Rapid Spin). Unfavorable weather can cause similar damage too, by the way. Pokémon can be also paralyzed, which means no attacks in opponent's turn (also its speed counts as half of it when enemy wants to dodge or something). Being confused means one recoil damage from every attack performed. Sleeping Pokémon can't fight, but wakes when being damaged. Hidden Pokémon is invulnerable. And there is also a Leech Seed, which can drain hp.
				<br><br>
				Your goal is to decrease all opponent's Pokémon's health points to zero. And, of course, be the very best.
			</div>
					
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
	echo "<script src='playerpanel.js'></script>";
	?>
	
</body>
</html>