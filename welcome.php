<?php
	session_start();
	
	if(!isset($_SESSION['correctregistration'])){
		header('Location: index.php');
		exit();
	}
	else{
		unset($_SESSION['correctregistration']);
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
				Password: <br/><input type="password" name="haslo" /> <br/><br/>
				<input type="submit" value="Zaloguj się" />
			</form>
			<br/>
			<?php
				if(isset($_SESSION['loginerror']))
				echo $_SESSION['loginerror'];
			?>
			
		</div>
		
		<main>
			Dziękujemy za rejestrację. Możesz już zalogować się na swoje konto.
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
