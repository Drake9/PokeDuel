
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
	
	</header>
	
	<div id="container">
		
		<div class="sidepanel" id="menuleft">
		
		</div>
		
		<main>
					
			<div class="paragraph" id="paragraph1">
				Regulamin
				<br><br>
				1. Zarejestrowanemu użytkownikowi zezwala się:<br>
					- tworzyć w Poképanelu własną drużynę<br>
					- grać z innymi<br>
					- dobrze się bawić
				<br><br>	
				2. Zarejestrowanemu użytkownikowi zabrania się wszystkich rzeczy niewymienionych w punkcie pierwszym. Użytkownikowi niezarejestrowanemu zabrania się wszystkiego, oprócz rejestracji.
				<br><br>
				3. Nick, który użytkownik podaje w procesie rejestracji, nie może zawierać jego imienia i nazwiska ani żadnych innych danych osobowych. Co za tym idzie, administrator nie pobiera od użytkownika i nie przechowuje żadnych jego danych osobowych. Administrator nie odpowiada za dane osobowe, które otrzymał wbrew swojej woli i niezgodnie z regulaminem.
				<br><br>
				4. Administrator zastrzega sobie wyłączne prawo do dowolnego modyfikowania strony jak i bazy danych, w szczególności do usuwania kont łamiących regulamin.
				<br><br>
				5. Administrator oświadcza, że nie czerpie z funkcjonowania swojej strony internetowej żadnych korzyści majątkowych (przez co jest jest mu trochę smutno).
				<br><br>
				6. Część podstron jest po angielsku. Jeżeli stanowi to dla użytkownika problem, to ma on problem.
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