<?php
	session_start();
	
	if(!isset($_SESSION['loggedin']) || $_SESSION['user'] != "Trox"){
		header('Location: index.php');
		exit();
	}
	
	if(isset($_POST['nick'])){
		$all_right=true;
		
		//nickname
		$nick=$_POST['nick'];
		if((strlen($nick)<3)||(strlen($nick)>20)){
			$all_right=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if(ctype_alnum($nick)==false){
			$all_right=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków).";
		}
		
		
		//password
		$pass1=$_POST['pass1'];
		$pass2=$_POST['pass2'];
		
		if((strlen($pass1)<8)||(strlen($pass1)>20)){
			$all_right=false;
			$_SESSION['e_pass']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if($pass1!=$pass2){
			$all_right=false;
			$_SESSION['e_pass']="Podane hasła nie są identyczne!";
		}
		
		$hash = password_hash($pass1, PASSWORD_DEFAULT);
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
					
				//czy login już istnieje
				$result=$connection->query("SELECT id FROM players WHERE nick='$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$how_many_nicks=$result->num_rows;
				if($how_many_nicks<1){
					$all_right=false;
					$_SESSION['e_nick']="Nie istnieje konto o podanym nicku.";
					}
				
				if($all_right==true){
					//dane poprawne, wstawiamy do bazy
					
					if($connection->query("UPDATE players SET password='$hash' WHERE nick='$nick'")){
						header('Location: playerpanel.php');
					}
					else{
						throw new Exception($connection->error);
					}
				}
				
				$connection->close();
			}
		}
		catch(Exception $err){
			echo '<span style="color:red;">Błąd serwera. Przepraszamy. Spróbuj ponownie później.</span>';
			echo '<br/>Informacja deweloperska: '.$err;
		}
	
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>PokéDuel - załóż darmowe konto</title>
	
	<link rel="stylesheet" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Freckle+Face&amp;subset=latin-ext" rel="stylesheet">
	
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

	<header>

		<h1 class="logo" >PokéDuel</h1>
	
	</header>
	
	<div id="container">
		<div class="sidepanel">
		</div>
		
		<main>
			<form method="post">
			
			Nickname: <br/> <input type = "text" name="nick" /> <br/>
			<?php
				if(isset($_SESSION['e_nick'])){
					echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
			?>

			Nowe hasło: <br/> <input type = "password" name="pass1" /> <br/>
			<?php
				if(isset($_SESSION['e_pass'])){
					echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
					unset($_SESSION['e_pass']);
				}
			?>
			
			Powtórz hasło: <br/> <input type = "password" name="pass2" /> <br/>
			
			<br/>
			
			<input type="submit" value="Zmień hasło" />
			
			</form>
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