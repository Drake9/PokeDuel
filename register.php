<?php
	session_start();
	
	if(isset($_POST['nick'])){
		//udana walidacja
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
		
		//mail
		$email="fake_mail@gmail.com";
		$emailB=filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false)||($email!=$emailB)){
			$all_right=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
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
		
		$hash=password_hash($pass1, PASSWORD_DEFAULT);
		
		//regulamin
		if(!isset($_POST['rules'])){
			$all_right=false;
			$_SESSION['e_regulamin']="Proszę zaakceptować regulamin!";
		}
		
		//captha
		$secret="6LfI0jcUAAAAAK01KHt4TbybsVJcs_kIwE4Q1QNO";
		
		$antibot=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$response=json_decode($antibot);
		
		if($response->success==false){
			$all_right=false;
			$_SESSION['e_bot']="Proszę nie być robotem!";
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
				//czy email już istnieje
				$result=$connection->query("SELECT id FROM players WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$how_many_emails=$result->num_rows;
				if($how_many_emails>0){
					$all_right=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do podanego adresu email.";
					}
					
				//czy login już istnieje
				$result=$connection->query("SELECT id FROM players WHERE nick='$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$how_many_nicks=$result->num_rows;
				if($how_many_nicks>0){
					$all_right=false;
					$_SESSION['e_nick']="Istnieje już konto o podanym nicku.";
					}
				
				if($all_right==true){
					//dane poprawne, wstawiamy do bazy
					
					if($connection->query("INSERT INTO players VALUES (NULL, '$nick', '$hash', '$email', now(), '0' )")){
						
						if($result=$connection->query("SELECT id FROM players WHERE nick='$nick'")){
							
							$wiersz=$result->fetch_assoc();
							$id=$wiersz['id'];
							
							if($connection->query("INSERT INTO pokemons (`id`, `playerid`, `pokenumber`, `attack1`, `attack2`, `attack3`, `attack4`, `attack5`, `attack6`) VALUES (NULL, '$id', '1', '1', '1', '1', '2', '2', '2'), (NULL, '$id', '4', '1', '1', '1', '2', '2', '2'), (NULL, '$id', '7', '1', '1', '1', '2', '2', '2'), (NULL, '$id', '10', '1', '1', '1', '2', '2', '2'), (NULL, '$id', '16', '1', '1', '1', '2', '2', '2'), (NULL, '$id', '19', '1', '1', '1', '2', '2', '2');")){
						
								$_SESSION['correctregistration']=true;
								header('Location: welcome.php');
							}
							else{
								throw new Exception($connection->error);
							}
						}
						else{
							throw new Exception($connection->error);
						}
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
			<br>
			Hasło: <br/> <input type = "password" name="pass1" /> <br/>
			<?php
				if(isset($_SESSION['e_pass'])){
					echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
					unset($_SESSION['e_pass']);
				}
			?>
			<br>
			Powtórz hasło: <br/> <input type = "password" name="pass2" /> <br/>
			<br>
			<label>
				<input type="checkbox" name="rules" /> Akceptuję <a href="regulamin.php">regulamin</a>.
			</label>
			<?php
				if(isset($_SESSION['e_regulamin'])){
					echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
					unset($_SESSION['e_regulamin']);
				}
			?>
			<br><br>
			<div class="g-recaptcha" data-sitekey="6LfI0jcUAAAAABvH9jGrgTngRBUtfJxVg3SKmcxF"></div>
			<?php
				if(isset($_SESSION['e_bot'])){
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
					unset($_SESSION['e_bot']);
				}
			?>
			<br/>
			
			<input type="submit" value="Zarejestruj się" />
			
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