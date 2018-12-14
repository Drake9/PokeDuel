<?php
	session_start();
	
	if((isset($_SESSION['loggedin']))&&($_SESSION['loggedin']==true)){
		header('Location: game.php');
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
	<link href="https://fonts.googleapis.com/css?family=Acme|Freckle+Face&amp;subset=latin-ext" rel="stylesheet"> 
</head>

<body>

	<header>

		<h1 class="logo" >PokéDuel</h1>
	
	</header>
	
	<div id="container">
		<div class="sidepanel">
			<form action="login.php" method="post">
				Login: <br/><input type="text" name="login" /> <br/>
				Password: <br/><input type="password" name="password" /> <br/><br/>
				<input type="submit" value="Zaloguj się" />
			</form>
			<br/>
			<?php
				if(isset($_SESSION['loginerror']))
				echo $_SESSION['loginerror'];
			?>
			<br/><br/>
			<a href ="register.php" >Nie masz konta? Zarejestruj się!</a>
		</div>
		
		<main>
			Witaj w grze PokéDuel. Niniejsza gra powstała jedynie w celach dydaktycznych; jej autor, tworząc ją, szlifował swoje umiejętności w tworzeniu stron internetowych. Autor nie czerpie z niniejszej strony żadnych materialnych korzyści. Oficjalna gra karciana Pokémon dostępna jest <a href="https://www.pokemon.com/us/pokemon-tcg/" target="_blank" >tutaj</a>. Nie wiesz, czym są Pokémony? Kliknij <a href="https://pl.wikipedia.org/wiki/Pok%C3%A9mon" target="_blank" >tutaj</a>.
		</main>
		
		<div class="sidepanel">
		</div>
		
		<div style="clear: both;">
		</div>
		
	</div>
	<footer>
		Wszelkie prawa zastrzeżone &copy; 2017 Dziękuję za wizytę!
	</footer>


</body>
</html>